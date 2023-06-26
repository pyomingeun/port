<?php

use App\Models\Features;
use App\Models\Facilities;
use App\Models\Rooms;
use Carbon\Carbon;
use App\Models\Reward;
use App\Models\User;
use App\Models\Booking;
use App\Models\Post;
use App\Models\NewsLetter;
use App\Models\Notification;
use App\Models\ChatMessage;

function getFeaturename($id)
{
  $Features = Features::find($id);
  return $Features->features_name;
}

function getFacilityname($id)
{
  $Features = Facilities::find($id);
  return $Features->facilities_name;
}

function getQueryParams($params)
{
  $paramsArray = [];
  foreach ($params as $key => $value) {
    array_push($paramsArray, "$key=$value");
  }
  $paramString = '?'.implode('&', $paramsArray);
  return $paramString;
}

function getRoomPrice($dayofweek, $hasActiveRooms, $hasLongStayDiscount)
{
  $originalPrice = ($dayofweek == 5 || $dayofweek == 6)?
    $hasActiveRooms->standard_price_weekend:
    $hasActiveRooms->standard_price_weekday;
  $showPrice = $originalPrice;
  $returnString = "₩" . siteNumberFormat($showPrice);
  if (count($hasLongStayDiscount) > 0) {
    $showPrice =($hasLongStayDiscount[0]->lsd_discount_type == 'percentage')?
      $showPrice - ($hasLongStayDiscount[0]->lsd_discount_amount / $showPrice * 100):
      $showPrice - $hasLongStayDiscount[0]->lsd_discount_amount;
    $returnString = "₩". siteNumberFormat($showPrice) . " <del>₩" .  siteNumberFormat($originalPrice) . "</del>";
  }
  
  return $returnString;
}

function getAllRoomMaxPrice($dayofweek) {

  return ($dayofweek == 5 || $dayofweek == 6)?
    Rooms::max('standard_price_weekend'):
    Rooms::max('standard_price_weekday');
}

// reward points update by admin 
function updateRewards($points,$user_id,$rtype,$title,$message,$status='pending',$bookingSlug='',$transaction_on='',$rewardBy='')
{
    // $access = auth()->user()->access;

    $randomId  = rand(1000,9999);
    $timestamp = Carbon::now()->timestamp;
    $slug = $timestamp."".$randomId;
    $user = User::where('id', '=', $user_id)->where('status', '!=', 'deleted')->first();
    if($user)
    {
        $creditedPoints = Reward::where('user_id','=',$user_id)->where('reward_type','=','credited')->where('status','=','active')->sum('reward_points');
        $debitedPoints = Reward::where('user_id','=',$user_id)->where('reward_type','=','debited')->where('status','=','active')->sum('reward_points');
        
        $remaing_points = $creditedPoints-$debitedPoints;
        if($rtype == 'debited')
        {
            if($status=='active')
              $remaing_points = $remaing_points - $points;
        }
        
        if($rtype == 'credited')
        {
            if($status=='active')
            $remaing_points = $remaing_points + $points;
        }
        
        if($transaction_on =='')
          $transaction_on = date_format(Carbon::now(),"Y-m-d");
        if($rewardBy =='')
            $rewardBy = auth()->user()->id;

        $newReward= Reward::create([
            'slug' => $slug,
            'user_id' => $user_id,
            'booking_slug'=>$bookingSlug,
            'title'=>$title,
            'message'=>$message,
            'reward_points'=>$points,
            'remaing_points'=>$remaing_points,
            'reward_type'=>$rtype,
            'transaction_on'=>$transaction_on,
            'status'=>$status,
            'created_by'=>$rewardBy,
            'updated_by'=>$rewardBy,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
          ]);
        
        if($newReward)
        {
            $user->total_rewards_points = $remaing_points;
            $user->save();
            $data = [
                'status' => 1
            ];    
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 0,
                'message' =>'Somthing went wrong.'
            ];
            return response()->json($data);
        }    
    }
    else
    {
        $data = [
            'status' => 0,
            'message' =>'Somthing went wrong.'
        ];
        return response()->json($data);   
    }
}

function checkIsRoomBooked($room_id, $check_in_date, $check_out_date,$booking_id='')
{
    $whereBookingIdNot = '';
    if($booking_id != '')
      $whereBookingIdNot = " AND id !='".$booking_id."' ";

    // $sql = "SELECT * FROM `bookings` WHERE room_id = '".$room_id."' AND ( ((check_in_date = '".$check_in_date."' || check_out_date ='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_out_date."')  || (check_out_date >= '".$check_in_date."' && check_out_date <='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_in_date."') || (check_in_date <= '".$check_in_date."' && check_out_date >='".$check_out_date."') || (check_in_date <= '".$check_out_date."' && check_out_date >='".$check_out_date."') ) AND (booking_status='on_hold' || booking_status='confirmed' || booking_status='blocked') AND status='active' '".$whereBookingIdNot."')"; 
    $sql = "SELECT * FROM `bookings` WHERE room_id = '".$room_id."' AND ( ((check_in_date = '".$check_in_date."' ) || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_out_date."')  || (check_out_date > '".$check_in_date."' && check_out_date <'".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_in_date."') || (check_in_date <= '".$check_in_date."' && check_out_date >'".$check_out_date."') || (check_in_date <= '".$check_out_date."' && check_out_date >'".$check_out_date."') ) AND (booking_status='on_hold' || booking_status='confirmed' || booking_status='blocked') AND status='active' '".$whereBookingIdNot."')";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

// check given date is peak season or not
function thisDateIsPeakSeason($hotel_id, $date)
{
    $sql = "SELECT * FROM `hotel_peak_season` WHERE hotel_id = '".$hotel_id."' ( ((start_date = '".$date."' || end_date ='".$date."') || (start_date >= '".$date."' && start_date <='".$date."')  || (end_date >= '".$date."' && end_date <='".$date."') || (start_date >= '".$date."' && start_date <='".$date."') || (start_date <= '".$date."' && end_date >='".$date."') || (start_date <= '".$date."' && end_date >='".$date."') ) AND status='active')"; 
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

function checkIsRoomBlocked($room_id, $check_in_date, $check_out_date,$booking_id='')
{
    $whereBookingIdNot = '';
    if($booking_id != '')
      $whereBookingIdNot = " AND id !='".$booking_id."' ";

    $sql = "SELECT * FROM `bookings` WHERE room_id = '".$room_id."' AND ( ((check_in_date = '".$check_in_date."' || check_out_date ='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_out_date."')  || (check_out_date >= '".$check_in_date."' && check_out_date <='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_in_date."') || (check_in_date <= '".$check_in_date."' && check_out_date >='".$check_out_date."') || (check_in_date <= '".$check_out_date."' && check_out_date >='".$check_out_date."') ) AND (booking_status='blocked') AND status='active' '".$whereBookingIdNot."')";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

function checkIsRoomBookedNotBlocked($room_id, $check_in_date, $check_out_date,$booking_id='')
{
    $whereBookingIdNot = '';
    if($booking_id != '')
      $whereBookingIdNot = " AND id !='".$booking_id."' ";

    $sql = "SELECT * FROM `bookings` WHERE room_id = '".$room_id."' AND ( ((check_in_date = '".$check_in_date."' || check_out_date ='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_out_date."')  || (check_out_date >= '".$check_in_date."' && check_out_date <='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_in_date."') || (check_in_date <= '".$check_in_date."' && check_out_date >='".$check_out_date."') || (check_in_date <= '".$check_out_date."' && check_out_date >='".$check_out_date."') ) AND (booking_status='on_hold' || booking_status='confirmed') AND status='active' '".$whereBookingIdNot."')";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

function checkRoomStatus($room_id, $date)
{
    $sql = "SELECT id,slug,check_in_date,check_out_date,booking_status FROM `bookings` WHERE room_id = '".$room_id."' AND  ( (check_in_date = '".$date."' || check_out_date ='".$date."') || (check_in_date <= '".$date."' && check_out_date >='".$date."') ) AND (booking_status='on_hold' || booking_status='confirmed' || booking_status='completed' || booking_status='blocked') AND status='active' LIMIT 1";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

function checkRoomBlocked($room_id, $date)
{
    $sql = "SELECT id,slug,check_in_date,check_out_date,booking_status FROM `bookings` WHERE room_id = '".$room_id."' AND  ( (check_in_date = '".$date."' || check_out_date ='".$date."') || (check_in_date <= '".$date."' && check_out_date >='".$date."') ) AND (booking_status='on_hold' || booking_status='confirmed' || booking_status='completed' || booking_status='blocked') AND status='active' LIMIT 1";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}
 
function checkRoomOccupancy($room_id,$adults,$childs)
{
  $room = Rooms::where('id', '=', $room_id)->where('maximum_occupancy_adult', '>=', $adults)->where('maximum_occupancy_child', '>=', $childs)->first();
   return $room; 
}

function getRefundDetails($id) 
{
    $booking = Booking::where('id','=',$id)->where('status','=','active')->first();
    $refundDetails = [];
    $refundDetails['refund_amount_in_points'] = 0;
    $refundDetails['refund_points'] = 0;
    $refundDetails['refund_amount_in_money'] = 0;
    $refundDetails['total_refund_amount'] = 0;
    $refundDetails['numberOfBeforeDays'] = 0;
    $refundDetails['refund_in_percentage'] = 0;
    if($booking)
    {
        $today = Carbon::now(); //Carbon::now(); // date_format(Carbon::now(),"Y-m-d");
        $check_in_date =Carbon::parse($booking->check_in_date);
        
        $numberOfBeforeDays = $check_in_date->diffInDays($today);
       //  Carbon::parse($booking->check_in_date)->gt(Carbon::now())
        if(Carbon::parse($booking->check_in_date)->gt(Carbon::now()))
        {
          // $numberOfBeforeDays= $check_in_date->diff($today)->format("%a");
          // $length = $check_in_date->diffInDays($today);
          // dd($numberOfBeforeDays);
          $numberOfBeforeDays = ($numberOfBeforeDays <=0)?0:$numberOfBeforeDays;

          $cancellation_policy = [];
          if($booking->cancellation_policy !='')
          {
            $cancellation_policy = json_decode($booking->cancellation_policy);
            $cancellation_policy = (array) $cancellation_policy;
          }   
          // var_dump($cancellation_policy); die;
          //     dd($cancellation_policy);
          $booking_total_amount = (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount))+$booking->extra_services_charges; 

          $applicableRefundPercentage  = 0;
          $refundDetails['numberOfBeforeDays'] = $numberOfBeforeDays;
          if($booking->cancellation_policy !='')
          {
            if($numberOfBeforeDays == 0)
            {
                $applicableRefundPercentage =  $cancellation_policy['same_day_refund'];
            }
            else if($numberOfBeforeDays == 1)
            {
                $applicableRefundPercentage =  $cancellation_policy['b4_1day_refund'];
            }
            else if($numberOfBeforeDays >= 2 && $numberOfBeforeDays <= 10)
            {
                $key =  'b4_'.$numberOfBeforeDays.'days_refund';
                $applicableRefundPercentage =  $cancellation_policy[$key]; //$cancellation_policy['b4_'.$numberOfBeforeDays.'days_refund'];
            }
            else
            {
                $applicableRefundPercentage = $cancellation_policy['b4_10days_refund'];
            }    
                  
          }
          $refundDetails['refund_in_percentage'] = $applicableRefundPercentage;

          $refundAmount = (($booking_total_amount/100)*$applicableRefundPercentage);
          if($booking->payment_by_points > 0 && $booking->reward_points_used > 0)
             $pointValueInMoney = $booking->payment_by_points/$booking->reward_points_used;
          else
             $pointValueInMoney = 0;
          // var_dump($booking->payment_by_points);
          // var_dump($refundAmount);
          // die;
          // dd($refundDetails);
          if($booking->payment_by_points > $refundAmount)
          {
              $refundDetails['refund_amount_in_points'] = $refundAmount;
              $refundDetails['refund_points'] = $booking->payment_by_points;
              $refundDetails['refund_amount_in_money'] = 0; //  $refundAmount - $booking->payment_by_points;
              $refundDetails['total_refund_amount'] = $refundAmount;
          }
          else
          {
              $refundDetails['refund_points'] = $booking->reward_points_used;
              $refundDetails['refund_amount_in_points'] = $booking->payment_by_points;
              $refundDetails['refund_amount_in_money'] = $refundAmount - $booking->payment_by_points;
              $refundDetails['total_refund_amount'] = $refundAmount;            
          }
        }

    }
    return $refundDetails;
}

function getTopMagazine() 
{
  $posts =Post::where('status', 'active')->where('type', 'magazine')->orderBy('id', 'desc')->take(10)->get();
  return $posts;
}

function getTopEvent() 
{
  $posts =Post::where('status', 'active')->where('type', 'events')->orderBy('id', 'desc')->take(10)->get();
  return $posts;
}

function siteNumberFormat($number=0)
{
    round($number);
    $nombre_format_francais = number_format($number, 0, ',');
    return $nombre_format_francais;  
}

function subsribeUs($email,$user_id )
{
      $email = strtolower($email);
     
      $isExist = NewsLetter::where('email', '=', $email)->where('status', '!=', 'deleted')->first();

      if($isExist)
      {
          if($isExist->status =='deleted')
          {
              $isExist->email = $email;
              $isExist->is_subscribed = 1;
              $isExist->status = 'active';
              $isExist->updated_by = $user_id;
              $isExist->updated_at = Carbon::now();
              $isExist->save();
  
              $data = [
                  'status' => 1,
                  'message' => 'Thank-you for subscribe news-letter.'
              ];
              return response()->json($data);
          }
          else
          {
              $data = [
                  'status' => 0,
                  'message' => 'You are already our subscriber.'
              ];
              return response()->json($data);
          }
      }
      else
      {
          $newFeatures= NewsLetter::create([
              'email' => $email,
              'is_subscribed' =>1, 
              'status' =>'active', 
              'created_by'=>$user_id,
              'updated_by'=>$user_id,
              'created_at'=>Carbon::now(),
              'updated_at'=>Carbon::now(),          
          ]);
          
          if($newFeatures)
          {
              $data = [
                  'status' => 1,
                  'message' => 'Thank-you for subscribe news-letter.',
              ];

              return response()->json($data);
          }   
      }
}

function sendNotification($user_id,$message="",$booking_id=0)
{
    $newNotification = Notification::create([
        'user_id' => $user_id,
        'booking_id' =>$booking_id, 
        'message' =>$message, 
        'status' =>'active', 
        'created_by'=>$user_id,
        'updated_by'=>$user_id,
        'created_at'=>Carbon::now(),
        'updated_at'=>Carbon::now(),          
    ]);
    return $newNotification;
}

// get no. of rooms confirmed in given date
function getNoOfRoomsConfirmed($check_in_date, $check_out_date, $hotel_id=0)
{
    $whereHotelId = '';
    if($hotel_id != '' && $hotel_id != 0)
      $whereHotelId = " AND hotel_id ='".$hotel_id."' ";

    $sql = "SELECT count(id) as count FROM `bookings` WHERE ( ((check_in_date = '".$check_in_date."' || check_out_date ='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_out_date."')  || (check_out_date >= '".$check_in_date."' && check_out_date <='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_in_date."') || (check_in_date <= '".$check_in_date."' && check_out_date >='".$check_out_date."') || (check_in_date <= '".$check_out_date."' && check_out_date >='".$check_out_date."') ) AND (booking_status='confirmed') AND status='active' '".$whereHotelId."')";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

// get no. of rooms on-hold in given date
function getNoOfRoomsOnhold($check_in_date, $check_out_date, $hotel_id=0 )
{
    $whereHotelId = '';
    if($hotel_id != '' && $hotel_id != 0)
      $whereHotelId = " AND hotel_id ='".$hotel_id."' ";

    $sql = "SELECT count(id) as count FROM `bookings` WHERE  ( ((check_in_date = '".$check_in_date."' || check_out_date ='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_out_date."')  || (check_out_date >= '".$check_in_date."' && check_out_date <='".$check_out_date."') || (check_in_date >= '".$check_in_date."' && check_in_date <='".$check_in_date."') || (check_in_date <= '".$check_in_date."' && check_out_date >='".$check_out_date."') || (check_in_date <= '".$check_out_date."' && check_out_date >='".$check_out_date."') ) AND (booking_status='on_hold') AND status='active' '".$whereHotelId."')";
    $isRoomBooked = DB::select($sql);
    return $isRoomBooked;
}

function getUnreadMessage()
{
    $chatCount = 0;
    if(auth()->user()) {
      $chatCount = ChatMessage::where('receiver_id', auth()->user()->id)->where('is_read', 0)->count();
    }
    return $chatCount;
}
