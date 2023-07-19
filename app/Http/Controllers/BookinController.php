<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\HotelInfo;
use App\Models\RatingReview;
use App\Models\User;
use App\Models\AdminGlobalVariable;
use App\Models\AdditionalDiscount;
use App\Models\BookingExtraService;
use App\Models\HotelExtraServices;
use App\Models\Rooms;
use App\Models\BookingCancelDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerBookingCancelEmail;
use App\Mail\CustomerBookingConfirmEmail;
use App\Mail\HotelBookingCancelEmail;
use App\Mail\HotelBookingConfirmEmail;

use DB;
use Carbon\Carbon;

use Session;
use Illuminate\Support\Facades\Auth;

class BookinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        // return view('customer.my_bookings');//->with(['hoteles'=>$hoteles]);
    }

    // booking listing in customer end 
    public function customerBooking()
    {
        $loggedid = auth()->user()->id;
        $query = Booking::join('hotel_info', 'hotel_info.hotel_id', '=', 'bookings.hotel_id');
        $query->where('bookings.status', '=', 'active');
        $query->where('bookings.customer_id', '=', $loggedid);
        $query->select(['hotel_info.hotel_name','hotel_info.featured_img','hotel_info.slug','hotel_info.street','hotel_info.city','hotel_info.pincode','hotel_info.subrub','hotel_info.rating','hotel_info.reviews','hotel_info.check_in','hotel_info.check_out', 'bookings.*']);
        $query->orderBy('bookings.id','desc');
        $bookings = $query->get();
        return view('customer.my_bookings')->with(['bookings'=>$bookings]);        
    }

    public function bookingDetails($slug)
    {
        if(auth()->user()->access =='customer')
        {
            $col = 'customer_id';
            $val = auth()->user()->id;
        }
        elseif(auth()->user()->access =='hotel_manager') 
        {
            $col = 'hotel_id';
            $val = auth()->user()->id;
        }
        else
        {
            $col = 'hotel_id';
            $val = auth()->user()->hotel_id;
        }

        $query = Booking::join('hotel_info', 'hotel_info.hotel_id', '=', 'bookings.hotel_id');
        $query->join('rooms','rooms.id', '=', 'bookings.room_id');
        $query->join('user','user.id', '=', 'bookings.hotel_id');
        $query->where('bookings.status', '=', 'active');
        $query->where('bookings.slug', '=', $slug);
        if(auth()->user()->access !='admin')
        $query->where('bookings.'.$col, '=', $val);
        $query->select(['hotel_info.hotel_name','hotel_info.featured_img','hotel_info.slug','hotel_info.street','hotel_info.city','hotel_info.pincode','hotel_info.subrub','hotel_info.rating','hotel_info.reviews','hotel_info.check_in','hotel_info.check_out','hotel_info.hotel_policy','rooms.room_name','user.email','user.phone', 'bookings.*']);
        $booking = $query->first();
        if($booking)
        { 
            // additional discount
            $discounts = AdditionalDiscount::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->get();
            /* $discounts_html = '';
            if(count($discounts) > 0)
            {
                $discounts_html = "<div class='tooltipbox discounttooltip'> ";
                foreach($discounts as $discount)
                {
                    $discounts_html .= "<p class='tltp-p'>  <span class='normalfont'>".$discount->reason." <small class='d-bloc ml-auto mediumfont'>₩ ".number_format($discount->effective_amount,2)."</small></span><span class='redb3'>×</span></small></p>";
                }
                $discounts_html .= "</div>";
            }
            $booking->discounts_html = $discounts_html; */ 
            // cancellation policy
            $cancellation_policy = [];
            if($booking->cancellation_policy !='')
                $cancellation_policy = json_decode($booking->cancellation_policy);
            // rating review
            $ratingReview = RatingReview::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->first();
            $BookingCancelDetail = BookingCancelDetail::where('booking_id', '=', $booking->id)->first();
            // extra services charges
            // $BookingExtraService = BookingExtraService::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->get();

            $BESquery = BookingExtraService::join('hotel_extra_services', 'hotel_extra_services.id', '=', 'booking_extra_services.es_id');
            $BESquery->where('booking_extra_services.status', '=', 'active');
            $BESquery->where('booking_extra_services.booking_id', '=', $booking->id);
            $BESquery->select(['hotel_extra_services.es_name', 'booking_extra_services.*']);
            $bookingExtraService = $BESquery->get();
            $refundDetails = [];
            if($booking->booking_status =='confirmed')
            $refundDetails = getRefundDetails($booking->id);

            if($booking->no_of_peakseason_days > 0 || $booking->no_of_weekend_days > 0 || $booking->no_of_week_days > 0)    
            $nightChargesInfo ="<div class='tooltipbox'>";
            else
                $nightChargesInfo ="";

            if($booking->no_of_peakseason_days > 0)
                $nightChargesInfo .="<p class='normalfont mb-0'>Peak Season: <small class='mediumfont'>$booking->no_of_peakseason_days x $booking->peakseason_price </small></p>";

            if($booking->no_of_weekenddays > 0)
                $nightChargesInfo .="<p class='normalfont mb-0'>Week-End(s): <small class='mediumfont'>$booking->no_of_weekenddays x $booking->weekend_price </small></p>";
                
            if($booking->no_of_weekdays > 0)
                $nightChargesInfo .="<p class='normalfont mb-0'>Week-Day(s): <small class='mediumfont'>$booking->no_of_weekdays x $booking->weekday_price </small></p>";    

            if($booking->no_of_peakseason_days > 0 || $booking->no_of_weekenddays > 0 || $booking->no_of_weekdays > 0)
                $nightChargesInfo .="</div>";

            if(auth()->user()->access == 'customer')
                return view('customer.booking_detail')->with(['booking'=>$booking,'ratingReview'=>$ratingReview,'cancellation_policy'=>$cancellation_policy,'discounts'=>$discounts,'bookingExtraService'=>$bookingExtraService,'BookingCancelDetail'=>$BookingCancelDetail,'refundDetails'=>$refundDetails,'nightChargesInfo'=>$nightChargesInfo]);
            else
                return view('hotel.booking_detail')->with(['booking'=>$booking,'ratingReview'=>$ratingReview,'cancellation_policy'=>$cancellation_policy,'discounts'=>$discounts,'bookingExtraService'=>$bookingExtraService,'BookingCancelDetail'=>$BookingCancelDetail,'refundDetails'=>$refundDetails,'nightChargesInfo'=>$nightChargesInfo]);
        }
        else
            return redirect()->route('home'); 

    }

    // booking listing in hotel manageer/satff end 
    public function hotelBooking()
    {
        $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
        $query = Booking::join('hotel_info', 'hotel_info.hotel_id', '=', 'bookings.hotel_id');
        $query->join('rooms','rooms.id', '=', 'bookings.room_id');
        $query->where('bookings.status', '=', 'active');
        $query->where('bookings.booking_status', '!=', 'blocked');
        if(auth()->user()->access !='admin')
        $query->where('bookings.hotel_id', '=', $hotel_id);
        $query->select(['hotel_info.hotel_name','hotel_info.featured_img','hotel_info.slug','hotel_info.formatted_address','hotel_info.sido','hotel_info.sigungu', 'hotel_info.rating','hotel_info.reviews','hotel_info.check_in','hotel_info.check_out','rooms.room_name', 'bookings.*']);
        $query->orderBy('bookings.id','desc');
        $bookings = $query->get();
        if(auth()->user()->access =='admin')
        {
            $hotels = HotelInfo::where('status', '!=', 'deleted')->select('id','hotel_id','slug','hotel_name')->get();
            return view('hotel.my_bookings')->with(['bookings'=>$bookings, 'hotels'=>$hotels]);         
        }    
            return view('hotel.my_bookings')->with(['bookings'=>$bookings]);         
    }

    // make booking cancel 
    public function bookingCancel(Request $request)
    {
        if(auth()->user()->access == 'customer')
        {
            $booking = Booking::where('slug', '=', $request->b)->where('customer_id', '=', auth()->user()->id)->where('status', '=', 'active')->first();

            if($booking)
            {
                if($booking->booking_status !='completed' && $booking->booking_status !='cancelled')
                {
                    if($booking->booking_status =='on_hold' && $booking->payment_status !='paid')
                    {
                        $BCD = BookingCancelDetail::create([
                            'booking_id' => $booking->id,
                            'refund_status'=>'no_refund',
                            'refund_points'=> $booking->reward_points_used,
                            'refund_amount_in_money'=> $booking->payment_by_points,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'cancellation_reason'=>''
                        ]);

                        updateRewards($booking->reward_points_used,$booking->customer_id,'credited','Booking Cancel','Reward points return for booking','active',$booking->slug,'',1);
                    }
                    elseif($booking->booking_status =='confirmed' && $booking->payment_status =='paid') 
                    {
                        $refundDetails = getRefundDetails($booking->id);
                        $refund_status = ($refundDetails['refund_amount_in_money'] == 0)?'refunded':'refund_pending';
                        $BCD = BookingCancelDetail::create([
                            'booking_id' => $booking->id,
                            'refund_amount_in_points' => $refundDetails['refund_amount_in_points'],
                            'refund_amount_in_money' => $refundDetails['refund_amount_in_money'],
                            'refund_points' => $refundDetails['refund_points'],
                            'total_refund_amount' => $refundDetails['total_refund_amount'],
                            'cancellation_before_n_days' => $refundDetails['numberOfBeforeDays'],
                            'refund_percentage' => $refundDetails['refund_in_percentage'],
                            'refund_status'=>$refund_status,
                            'cancellation_reason'=>$request->cr,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                        if($refundDetails['refund_points'] !=0)
                        {
                            updateRewards($refundDetails['refund_points'],$booking->customer_id,'credited','Booking Cancel','Reward points return for booking','active',$booking->slug,'',1);                                       
                        }

                    }

                    if($booking->customer_id !=0)
                        sendNotification($booking->customer_id,$message="Your booking is successfully cancelled",$booking->id);

                    $customer_email_data = [
                        'name' => $booking->customer_full_name
                    ];
                    Mail::to($booking->customer_email)->send(new CustomerBookingCancelEmail($customer_email_data));
                    
                    // email notification sent to hotel if hotel set yes for email notification
                    $hotelNS = NotificationSetting::where('status', '=', 'active')->where('user_id', '=', $booking->hotel_id)->select(['*'])->first();
                    if($hotelNS)
                    {
                        if($hotelNS->booking_cancelled_email == 1)
                        {
                            $hotelEmail = User::where('id', '=', $booking->hotel_id)->select(['email'])->first();
                            $hotel_email_data = [
                                'name' => $hotelEmail->full_name
                            ];
                            Mail::to($hotelEmail->email)->send(new HotelBookingCancelEmail($hotel_email_data));
                        }
                    }
                    sendNotification($booking->hotel_id,$message="Your booking is successfully cancelled",$booking->id);    

                    $booking->booking_status ='cancelled';
                    $booking->cancelled_by=auth()->user()->id;
                    $booking->cancelled_at=Carbon::now();
                    $booking->save();
                    $data = [
                        'status'=>1,
                        'message' => "Booking cancelled successfully."
                    ];
                    return response()->json($data);
                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "This booking can not be cancel because this booking is already ".$booking->booking_status
                    ];
                    return response()->json($data);
                }
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "Something went wrong."
                ];
                return response()->json($data);
            }
        }
        elseif(auth()->user()->access =='hotel_manager' || auth()->user()->access =='hotel_staff')
        {
            $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
            $booking = Booking::where('slug', '=', $request->b)->where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->first();

            if($booking)
            {
                if($booking->booking_status !='completed' && $booking->booking_status !='cancelled')
                {
                    
                    if($booking->booking_status =='on_hold' && $booking->payment_status !='paid')
                    {
                        $BCD = BookingCancelDetail::create([
                            'booking_id' => $booking->id,
                            'refund_status'=>'no_refund',
                            'refund_points'=> $booking->reward_points_used,
                            'refund_amount_in_money'=> $booking->payment_by_points,
                            'created_by' => auth()->user()->id,
                            'updated_by' => auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                        updateRewards($booking->reward_points_used,$booking->customer_id,'credited','Booking Cancel','Reward points return for booking','active',$booking->slug,'',1);
                    }
                    elseif($booking->booking_status =='confirmed' && $booking->payment_status =='paid') 
                    {
                        $refundDetails = getRefundDetails($booking->id);
                        $refund_status = ($refundDetails['refund_amount_in_money'] == 0)?'refunded':'refund_pending';
                        if(isset($request->want_to_adjust) && $request->want_to_adjust ==1)
                        {   
                            $BCD = BookingCancelDetail::create([
                                'booking_id' => $booking->id,
                                'refund_amount_in_points' => $refundDetails['refund_amount_in_points'],
                                'refund_amount_in_money' => $request->adjusted_refund_price, //$refundDetails['refund_amount_in_money'],
                                'refund_points' => $refundDetails['refund_points'],
                                'total_refund_amount' => $request->adjusted_refund_price+$refundDetails['refund_amount_in_points'], // $refundDetails['total_refund_amount'],
                                'cancellation_before_n_days' => $refundDetails['numberOfBeforeDays'],
                                'refund_percentage' => $request->adjusted_refund_price, // $refundDetails['refund_in_percentage'],
                                'refund_status'=>$refund_status,
                                'cancellation_reason'=>$request->cancellation_reason,
                                'cancellation_reason'=>$request->cancellation_reason,
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);  
                            if($refundDetails['refund_points'] !=0)
                            {
                                updateRewards($refundDetails['refund_points'],$booking->customer_id,'credited','Booking Cancel','Reward points return for booking','active',$booking->slug,'',1);                                       
                            }    
                        }
                        else
                        {
                            $BCD = BookingCancelDetail::create([
                                'booking_id' => $booking->id,
                                'refund_amount_in_points' => $refundDetails['refund_amount_in_points'],
                                'refund_amount_in_money' => $refundDetails['refund_amount_in_money'],
                                'refund_points' => $refundDetails['refund_points'],
                                'total_refund_amount' => $refundDetails['total_refund_amount'],
                                'cancellation_before_n_days' => $refundDetails['numberOfBeforeDays'],
                                'refund_percentage' => $refundDetails['refund_in_percentage'],
                                'refund_status'=>$refund_status,
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]); 

                            if($refundDetails['refund_points'] !=0)
                            {
                                updateRewards($refundDetails['refund_points'],$booking->customer_id,'credited','Booking Cancel','Reward points return for booking','active',$booking->slug,'',1);                                       
                            }   
                        }
                    }

                    if($booking->customer_id !=0)
                    sendNotification($booking->customer_id,$message="Your booking is successfully cancelled",$booking->id);
                    
                    $customer_email_data = [
                        'name' => $booking->customer_full_name
                    ];
                    Mail::to($booking->customer_email)->send(new CustomerBookingCancelEmail($customer_email_data));

                    // email notification sent to hotel if hotel set yes for email notification
                    $hotelNS = NotificationSetting::where('status', '=', 'active')->where('user_id', '=', $booking->hotel_id)->select(['*'])->first();
                    if($hotelNS)
                    {
                        if($hotelNS->booking_cancelled_email == 1)
                        {
                            $hotelEmail = User::where('id', '=', $booking->hotel_id)->select(['email'])->first();
                            $hotel_email_data = [
                                'name' => $hotelEmail->full_name
                            ];
                            Mail::to($hotelEmail->email)->send(new HotelBookingCancelEmail($hotel_email_data));
                        }
                    }
                    sendNotification($booking->hotel_id,$message="Your booking is successfully cancelled",$booking->id);   

                    $booking->booking_status ='cancelled';
                    $booking->cancelled_by=auth()->user()->id;
                    $booking->cancelled_at=Carbon::now();
                    $booking->save();
                    $data = [
                        'status'=>1,
                        'message' => "Booking cancelled successfully."
                    ];
                    return response()->json($data);
                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "This booking can not be cancel because this booking is already ".$booking->booking_status
                    ];
                    return response()->json($data);
                }
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "Something went wrong."
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Something went wrong."
            ];
            return response()->json($data);
        } 
    }

    public function saveRefundBankInfo(Request $request)
    {
        if(auth()->user()->access =='customer')
        {
            $col = 'customer_id';
            $val = auth()->user()->id;
        }
        elseif(auth()->user()->access =='hotel_manager') 
        {
            $col = 'hotel_id';
            $val = auth()->user()->id;
        }
        else
        {
            $col = 'hotel_id';
            $val = auth()->user()->hotel_id;
        }

        $booking = Booking::where('slug', '=', $request->bs)->where($col, '=', $val)->where('booking_status', '=', 'cancelled')->first();

        if($booking)
        {
            $cancelInfo = BookingCancelDetail::where('booking_id', '=', $booking->id)->where('refund_status', '=', 'refund_pending')->first();
            if($cancelInfo)
            {
                $cancelInfo->bank_name = $request->rbn;
                $cancelInfo->iban_code = '';
                $cancelInfo->account_holder_name = $request->rachname;
                $cancelInfo->account_number = $request->rac;
                $cancelInfo->updated_by=auth()->user()->id;
                $cancelInfo->updated_at=Carbon::now();
                $cancelInfo->save();
                $data = [
                    'status'=>1,
                    'message' => "Bank details saved successfully."
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "You can not add bank details for this booking."
                ];
                return response()->json($data);
            }
            
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "You can not add bank details for this booking."
            ];
            return response()->json($data);
        }
        
    }

    public function refundBookingAmount(Request $request)
    {
        if(auth()->user()->access =='hotel_manager') 
        {
            $col = 'hotel_id';
            $val = auth()->user()->id;
        }
        else
        {
            $col = 'hotel_id';
            $val = auth()->user()->hotel_id;
        }

        $booking = Booking::where('slug', '=', $request->b)->where($col, '=', $val)->where('booking_status', '=', 'cancelled')->first();

        if($booking)
        {
            $cancelInfo = BookingCancelDetail::where('booking_id', '=', $booking->id)->where('refund_status', '=', 'refund_pending')->first();
            if($cancelInfo)
            {
                $cancelInfo->refund_status ='refunded';
                $cancelInfo->updated_by=auth()->user()->id;
                $cancelInfo->updated_at=Carbon::now();
                $cancelInfo->save();
                $data = [
                    'status'=>1,
                    'message' => "Refuned successfully."
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "You can not refund amount for this booking."
                ];
                return response()->json($data);
            }
            
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "You can not add bank details for this booking."
            ];
            return response()->json($data);
        }
    }   

    // make booking payment cofirm  
    public function paymentMakeConfirm(Request $request)
    {
        if(auth()->user()->access =='hotel_manager' || auth()->user()->access =='hotel_staff')
        {
            $today = date_format(Carbon::now(),"Y-m-d");
            $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
            $booking = Booking::where('slug', '=', $request->b)->where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->first(); // ->where("check_in_date",'>=', $totay)

            if($booking)
            {
                if($booking->check_in_date >= $today)
                {
                    if($booking->payment_status =='waiting' && $booking->booking_status=='on_hold')
                    {
                        $booking->payment_status ='paid';
                        $booking->booking_status ='confirmed';
                        $booking->confirmed_by=auth()->user()->id;
                        $booking->confirmed_at=Carbon::now();
                        $booking->save();

                        if($booking->customer_id !=0)
                        sendNotification($booking->customer_id,$message="Your booking payment marked confirmed successfully",$booking->id);
                        $customer_email_data = [
                            'name' => $booking->customer_full_name
                        ];
                        Mail::to($booking->customer_email)->send(new CustomerBookingConfirmEmail($customer_email_data));
                        
                        // email notification sent to hotel if hotel set yes for email notification
                        $hotelNS = NotificationSetting::where('status', '=', 'active')->where('user_id', '=', $booking->hotel_id)->select(['*'])->first();
                        if($hotelNS)
                        {
                            if($hotelNS->booking_confirmed_email == 1)
                            {
                                $hotelEmail = User::where('id', '=', $booking->hotel_id)->select(['email'])->first();
                                $hotel_email_data = [
                                    'name' => $hotelEmail->full_name
                                ];
                                Mail::to($hotelEmail->email)->send(new HotelBookingConfirmEmail($hotel_email_data));
                            }
                        }

                        sendNotification($booking->hotel_id,$message="Booking payment marked confirmed successfully",$booking->id); 

                        $data = [
                            'status'=>1,
                            'message' => "Payment confirmed successfully."
                        ];
                        return response()->json($data);
                    }
                    else
                    {
                        $data = [
                            'status'=>0,
                            'message' => "This booking can not be confirm because this booking is already ".$booking->booking_status
                        ];
                        return response()->json($data);
                    }
                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "This booking can not be confirm because check in date is passed"
                    ];
                    return response()->json($data);
                }    
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "Something went wrong."
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Something went wrong."
            ];
            return response()->json($data);
        } 
    }

    // Booking mark completed cronjob
    public function markBookingComplete()
    {
        $totay = date_format(Carbon::now(),"Y-m-d");
        $res = Booking::where("check_out_date",'<', $totay)->where("booking_status",'=', 'confirmed')->update(["booking_status" => "completed"]); 

        $bookings = Booking::where('is_points_sent', '=', 0)->where("check_out_date",'<', $totay)->where("booking_status",'=', 'completed')->where('payment_by_currency', '!=', 0)->where('customer_id', '!=', 0)->get();
    
        $points_earn_on_booking = AdminGlobalVariable::where('status', '=', 'active')->where('type','=','points_earn_on_booking')->first();
        $get_points =0;
        if($bookings)
        {
            if($points_earn_on_booking)
            {
                foreach($bookings as $booking)
                {
                    $get_points = 0;
                    $payment_by_currency = (float) $booking->payment_by_currency; 
                    if($points_earn_on_booking->value_type =='percentage')
                    {
                        $get_points =  round((($payment_by_currency/100)*$points_earn_on_booking->value));  
                    }   
                    else
                    {
                        $get_points = $points_earn_on_booking->value;
                    } 

                    updateRewards($get_points,$booking->customer_id,'credited','New Booking','You got this reward points for booking','active',$booking->slug,'',1);
                    $get_points = 0;    
                    $res = Booking::where("id",'=', $booking->id)->update(["is_points_sent" => 1]);                 
                }
            }
        }
        echo "bookings marked completed & points sent successfully.";
    }

    // apply additional discount
    public function applyAdditionalDiscount(Request $request)
    {
        $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
        $booking = Booking::where('slug', '=', $request->b)->where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->first();

        if($booking)
        {
            if($booking->booking_status =='on_hold')
            {
                $total_amount = (((($booking->per_night_charges + $booking->extra_guest_charges)-$booking->long_stay_discount_amount)-$booking->coupon_discount_amount)-$booking->payment_by_points) - $booking->additional_discount;
                $newAD = AdditionalDiscount::create([
                    'booking_id' => $booking->id,
                    'amount' => $request->ad_amount,
                    'amount_type' => $request->ad_type,
                    'reason' => $request->ad_reason,
                    'effective_amount'=>($request->ad_type =='percentage')?round((($total_amount/100)*$request->ad_amount),2): $request->ad_amount,
                    'status'=>'active',
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                
                if($newAD)
                {
                    // $newCoupon->booking()->attach($booking->id);
                    $additional_discounts = AdditionalDiscount::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->sum('effective_amount');
                    $booking->additional_discount = $additional_discounts;
                    $booking->save();
                    /* $additional_discounts = AdditionalDiscount::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->get();
                    $total_additional_discount_amount = 0;
                    if($additional_discounts)
                    {
                        foreach($additional_discounts as $additional_discount)
                        {
                            if($additional_discount->amount_type =='percentage')
                            { 
                                $total_additional_discount_amount +=  round((($booking->total_amount/100)*$additional_discount->amount));
                            }
                            else
                            {
                                $total_additional_discount_amount += $additional_discount->amount;
                            }
                        }
                    }
                    $booking->additional_discount = $total_additional_discount_amount;
                    $booking->save(); */
                    $data = [
                        'status'=>1,
                        'message' => "Discount applied successfully."
                    ];
                    return response()->json($data);
                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "Something went wrong."
                    ];
                    return response()->json($data);
                }

            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "This booking can not be apply additional discount because this booking is already ".$booking->booking_status
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Something went wrong."
            ];
            return response()->json($data);
        }

    }

    // remove additional discount
    public function removeAdditionalDiscount(Request $request)
    {
        $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
        $booking = Booking::where('slug', '=', $request->b)->where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->first();

        if($booking)
        {
            if($booking->booking_status =='on_hold')
            {
                $additional_discount = AdditionalDiscount::where('id', '=', $request->ad_id)->where('booking_id', '=', $booking->id)->where('status', '=', 'active')->first();
                if($additional_discount)
                {
                    $additional_discount->status = 'deleted';
                    $additional_discount->save();
                    
                    $additional_discounts = AdditionalDiscount::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->sum('effective_amount');
                    $booking->additional_discount = $additional_discounts;
                    $booking->save();
                    /* $additional_discounts = AdditionalDiscount::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->get();
                    $total_additional_discount_amount = 0;
                    if($additional_discounts)
                    {
                        foreach($additional_discounts as $additional_discount)
                        {
                            if($additional_discount->amount_type =='percentage')
                            {
                                // $newDiscountAmount = round((($booking->total_amount/100)*$additional_discount->amount)); 
                                $total_additional_discount_amount += round((($booking->total_amount/100)*$additional_discount->amount));
                            }
                            else
                            {
                                $total_additional_discount_amount += $additional_discount->amount;
                            }
                        }
                    }
                    $booking->additional_discount = $total_additional_discount_amount;
                    $booking->save(); */
                    $data = [
                        'status'=>1,
                        'message' => "Discount removed successfully."
                    ];
                    return response()->json($data);
                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "Something went wrong."
                    ];
                    return response()->json($data);
                }
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "This booking can not be remove additional discount because this booking is already ".$booking->booking_status
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Something went wrong."
            ];
        }
            
    }
    
    // edit-booking view
    public function editBooking($slug)
    {
        /* if(auth()->user()->access =='customer')
        {
            $col = 'customer_id';
            $val = auth()->user()->id;
        }
        else */
        if(auth()->user()->access =='hotel_manager') 
        {
            $col = 'hotel_id';
            $val = auth()->user()->id;
        }
        else
        {
            $col = 'hotel_id';
            $val = auth()->user()->hotel_id;
        }

        $query = Booking::join('hotel_info', 'hotel_info.hotel_id', '=', 'bookings.hotel_id');
        $query->join('rooms','rooms.id', '=', 'bookings.room_id');
        $query->join('user','user.id', '=', 'bookings.hotel_id');
        $query->where('bookings.status', '=', 'active');
        $query->where('bookings.slug', '=', $slug);
        $query->where('bookings.'.$col, '=', $val);
        $query->select(['hotel_info.hotel_name','hotel_info.featured_img','hotel_info.slug','hotel_info.street','hotel_info.city','hotel_info.pincode','hotel_info.subrub','hotel_info.rating','hotel_info.reviews','hotel_info.check_in','hotel_info.check_out','hotel_info.hotel_policy','rooms.room_name','user.email','user.phone', 'bookings.*']);
        $booking = $query->first();
        if($booking)
        { 
            // additional discount
            $discounts = AdditionalDiscount::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->get(); 
            // cancellation policy
            $cancellation_policy = [];
            if($booking->cancellation_policy !='')
                $cancellation_policy = json_decode($booking->cancellation_policy);
            // rating review
            $ratingReview = RatingReview::where('booking_id', '=', $booking->id)->where('status', '=', 'active')->first();

            $selected_es_ids = DB::select("select GROUP_CONCAT(DISTINCT(es_id)) as ids from booking_extra_services WHERE booking_id='".$booking->id."' AND status ='active'");
            
            $BESquery = BookingExtraService::join('hotel_extra_services', 'hotel_extra_services.id', '=', 'booking_extra_services.es_id');
            $BESquery->where('booking_extra_services.status', '=', 'active');
            $BESquery->where('booking_extra_services.booking_id', '=', $booking->id);
            $BESquery->select(['hotel_extra_services.es_name','hotel_extra_services.es_max_qty', 'booking_extra_services.*']);
            $bookingExtraService = $BESquery->get();
            // print_r($selected_es_ids[0]->ids); die;  
            if($selected_es_ids[0]->ids !=null)
            {
               $my_array1 = str_split($selected_es_ids[0]->ids);
               $extra_services = HotelExtraServices::where('hotel_id', '=', $booking->hotel_id)->where('status', '=', "active")->whereNotIn('id', $my_array1)->get();
            }   
            else
                $extra_services = HotelExtraServices::where('hotel_id', '=', $booking->hotel_id)->where('status', '=', "active")->get();

            return view('hotel.booking_edit')->with(['booking'=>$booking,'ratingReview'=>$ratingReview,'cancellation_policy'=>$cancellation_policy,'discounts'=>$discounts,'bookingExtraService'=>$bookingExtraService,'extra_services'=>$extra_services]);
        }
        else
            return redirect()->route('home');
    }

    // update booking details
    public function editBookingSubmit(Request $request)
    {
        $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
        $booking = Booking::where('slug', '=', $request->b)->where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->first();
        //   dd($request->es,$request->es_qty,$request->es_price); 
        if($booking)
        {
            if($booking->booking_status =='on_hold' || $booking->booking_status =='confirmed')
            {
                // if(count($request->es) == count($request->es_qty) && count($request->es) == count($request->es_price) )
                // {
                    $no_of_childs = $request->childs_below_nyear + $request->childs_plus_nyear; 
                    $room = checkRoomOccupancy($booking->room_id,$request->adults,$no_of_childs);
                    // print_r($room);
                    if($room)
                    {
                         // delete and insert features 
                        $res = BookingExtraService::where("booking_id", $booking->id)->update(["status" => "deleted"]);
                            
                        $counter = (isset($request->es) && count($request->es) >0)?count($request->es):0;
                        if($counter >0 )
                        {
                            for($i=0; $i<$counter; $i++)
                            {
                                $whereBookingES =array('es_id'=>$request->es[$i],'booking_id'=>$booking->id);
                                $is_es_exist = BookingExtraService::where($whereBookingES)->first(); 
                                
                                if($is_es_exist)
                                {
                                    $is_es_exist->status = 'active';
                                    $is_es_exist->price = $request->es_price[$i];
                                    $is_es_exist->qty = $request->es_qty[$i];
                                    $is_es_exist->es_row_total = round(($request->es_price[$i]*$request->es_qty[$i]),2);
                                    $is_es_exist->updated_by = auth()->user()->id;
                                    $is_es_exist->updated_at = Carbon::now();
                                    $is_es_exist->save();
                                }
                                else
                                {
                                    $newES = BookingExtraService::create([
                                        'booking_id' => $booking->id,
                                        'es_id' => $request->es[$i],
                                        'price' => $request->es_price[$i],
                                        'qty' => $request->es_qty[$i],
                                        'es_row_total' => round(($request->es_price[$i]*$request->es_qty[$i]),2),
                                        'status' =>'active',
                                        'created_by' => auth()->user()->id,
                                        'updated_by' => auth()->user()->id,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ]);                                   
                                }
                            }    
                        }

                        $extra_services_charges = BookingExtraService::where("booking_id", $booking->id)->where('status','=','active')->sum('es_row_total');
                        
                        $extraAdults = ($request->adults > $room->standard_occupancy_adult)?$request->adults - $room->standard_occupancy_adult:0;
                        $extraChilds = 0; 
                        if($no_of_childs > $room->standard_occupancy_child)
                        {
                            $extraChilds = $no_of_childs - $room->standard_occupancy_child;

                            $extraChilds  = ($extraChilds < $request->childs_plus_nyear)?$extraChilds:0;
                        }
                        
                        
                        $booking->no_of_adults = $request->adults;
                        $booking->childs_below_nyear = $request->childs_below_nyear;
                        $booking->childs_plus_nyear = $request->childs_plus_nyear;
                        $booking->no_of_childs = $no_of_childs;
                        $booking->no_of_extra_guest = $extraAdults + $extraChilds;
                        $booking->customer_notes = (isset($request->customer_notes) && $request->customer_notes !='')?$request->customer_notes:'';
                        $booking->host_notes = (isset($request->host_notes) && $request->host_notes !='')?$request->host_notes:'';
                        $booking->extra_services_charges = $extra_services_charges;
                        $booking->save();  
                        $nextpageurl = route('booking-detail', ['slug' => $booking->slug]);   
                        $data = [
                            'status'=>1,
                            'message' => "",
                            'nextpageurl'=>$nextpageurl
                        ];
                        return response()->json($data);   
                    }
                    else
                    {
                        $data = [
                            'status'=>0,
                            'message' => "Occupancy overload."
                        ];  
                        return response()->json($data);
                    }
                       
                /* }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "Something went wrong."
                    ];  
                    return response()->json($data);
                } */ 
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "This booking can not be edit because this booking is already ".$booking->booking_status
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Something went wrong."
            ];
            return response()->json($data);
        }       
    }

    // create-booking
    public function createBooking(Request $request)
    {
        $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
        $hotel = HotelInfo::where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->first();
        if($hotel)
        {
            $randomId  = rand(1000,9999);
            $timestamp = Carbon::now()->timestamp;
            $slug = $timestamp."".$randomId;

            $rooms = Rooms::where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->get();
            $extra_services = HotelExtraServices::where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->get();
            return view('hotel.booking_create')->with(['hotel'=>$hotel,'rooms'=>$rooms,'extra_services'=>$extra_services,'slug'=>$slug,'request'=>$request]);
        }
        else
            return redirect()->route('home');
    }

    // cancel-create-booking
    public function cancelCreateBooking(Request $request)
    {
        $request->session()->forget(['cb_check_in_date', 'cb_check_out_date','cb_customer_full_name','cb_customer_phone','cb_customer_email','cb_customer_notes','cb_adults','cb_childs','cb_childs_bellow_nyear','cb_childs_plus_nyear','cb_room_id','cb_room_name']);
        // ,'noOfExtraGuest','numberOfNights','ExtraGuestCharges','lsdAmount','roomStandardCharges','es_qty','extra_services','coupon_code_name','applied_discount_amount','discount_amount','max_discount_amount','discount_type','couponAppliedH','es_charges','extra_services','es_qty'
        return redirect()->route('bookings');
    }

    // booking create step-1
    public function createBookingStep1(Request $request)
    {
        $no_of_childs = $request->childs_bellow_nyear + $request->childs_plus_nyear;     
        $room = Rooms::where('slug', '=', $request->room)->where('status', '=', 'active')->where('maximum_occupancy_adult', '>=', $request->adults)->where('maximum_occupancy_child', '>=', $no_of_childs)->first();
        if($room)
        {
            $isRoomBooked = checkIsRoomBooked($room->id, $request->checkin, $request->checkout);
            if(count($isRoomBooked) <=0) 
            {
                $request->session()->put('cb_check_in_date', $request->checkin);
                $request->session()->put('cb_check_out_date', $request->checkout);
                $request->session()->put('cb_adults', $request->adults);
                $request->session()->put('cb_no_of_childs', $request->no_of_childs);
                $request->session()->put('cb_childs_bellow_nyear', $request->childs_bellow_nyear);
                $request->session()->put('cb_childs_plus_nyear', $request->childs_plus_nyear);
                $request->session()->put('cb_room_id', $room->id);
                $request->session()->put('cb_room_name', $room->room_name);

                $data = [
                    'status'=>1,
                    'message' => ""
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "Room not available for this dates."
                ];
                return response()->json($data);    
            } 
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Room not available for this occupancy"
            ];
            return response()->json($data);
        }
    }

    // booking create step-2 
    public function createBookingStep2(Request $request)
    {
        if($request->guest_fullname !='' && $request->guest_phone !='' && $request->guest_email !='')
        {
            $request->session()->put('cb_customer_full_name', $request->guest_fullname);
            $request->session()->put('cb_customer_phone', $request->guest_phone);
            $request->session()->put('cb_customer_email', $request->guest_email);
            $data = [
                'status'=>1,
                'message' => ""
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Primary Guest Details is required."
            ];
            return response()->json($data);
        }
    }

    // booking create step-3 
    public function createBookingStep3(Request $request)
    {
        if(strlen($request->customer_notes) <=400 && strlen($request->host_notes) <=400)
        {
            $request->session()->put('cb_customer_notes', $request->customer_notes);
            $request->session()->put('cb_host_notes', $request->host_notes);
            $data = [
                'status'=>1,
                'message' => ""
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Guest notes & Host notes should be less or equal to 400 charchters."
            ];
            return response()->json($data);
        }
    }

    // booking create step-4
    public function createBookingStep4(Request $request)
    {
        if(count($request->es) == count($request->es_qty))
        { 
            $request->session()->put('cb_check_in_date', $request->checkin);
            $request->session()->put('cb_check_out_date', $request->checkout);
            $request->session()->put('cb_adults', $request->adults);
            $request->session()->put('cb_no_of_childs', $request->no_of_childs);
            $request->session()->put('cb_childs_bellow_nyear', $request->childs_bellow_nyear);
            $request->session()->put('cb_childs_plus_nyear', $request->childs_plus_nyear);
            $request->session()->put('cb_room_id', $room->id);
            $request->session()->put('cb_room_name', $room->room_name);
            $request->session()->put('cb_guest_fullname', $request->guest_fullname);
            $request->session()->put('cb_customer_phone', $request->guest_phone);
            $request->session()->put('cb_customer_email', $request->guest_email);
            $request->session()->put('cb_customer_notes', $request->customer_notes);
            $request->session()->put('cb_host_notes', $request->host_notes);
            $request->session()->put('cb_es', $request->es);
            $request->session()->put('cb_es_qty', $request->es_qty);
            $request->session()->put('cb_es_name', $request->es_name);
            $request->session()->put('cb_es_price', $request->es_price);
            
            $data = [
                'status'=>1,
                'message' => ""
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Re-select extra services."
            ];
            return response()->json($data);
        }
    }

    // create Booking Submit
    public function createBookingSubmit(Request $request)
    {
        $no_of_childs = $request->childs_bellow_nyear + $request->childs_plus_nyear;     
        $room = Rooms::where('slug', '=', $request->room)->where('status', '=', 'active')->where('maximum_occupancy_adult', '>=', $request->adults)->where('maximum_occupancy_child', '>=', $no_of_childs)->first();
        if($room)
        {
            $isRoomBooked = checkIsRoomBooked($room->id, $request->checkin, $request->checkout);
            if(count($isRoomBooked) <=0) 
            {
                if($request->guest_fullname !='' && $request->guest_phone !='' && $request->guest_email !='')
                {
                    if(strlen($request->customer_notes) <=400 && strlen($request->host_notes) <=400)
                    {
                        if(count($request->es) == count($request->es_qty))
                        {
                            $hotel = HotelInfo::where('status', '=', 'active')->where('hotel_id', '=', $hotel_id)->first();
                            $data = [
                                'status'=>1,
                                'message' => ""
                            ];
                            return response()->json($data);
                        }
                        else
                        {
                            $data = [
                                'status'=>0,
                                'message' => "Re-select extra services."
                            ];
                            return response()->json($data);
                        }
                    }
                    else
                    {
                        $data = [
                            'status'=>0,
                            'message' => "Guest notes & Host notes should be less or equal to 400 charchters."
                        ];
                        return response()->json($data);
                    }
                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => "Primary Guest Details is required."
                    ];
                    return response()->json($data);
                }    
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => "Room not available for this dates."
                ];
                return response()->json($data);    
            } 
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => "Room not available for this occupancy"
            ];
            return response()->json($data);
        }
    }
}
