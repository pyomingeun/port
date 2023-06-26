<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelInfo;
use App\Models\Booking;
use App\Models\Payout;
use App\Models\PayoutHistory;
use App\Models\AdminGlobalVariable;
use App\Models\BookingCancelDetail;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PayoutCtrl extends Controller
{

    public function index()
    {
        $time_input = strtotime("2023-02-08"); 
        $date_input = getDate($time_input); 
        print_r($date_input);       
        echo "<br>";   

        $date="2023-02-08"; // date("Y-m-d");
        echo "Current Date : ".$time_input."<br>";
        echo "last Sunday : ".date('Y-m-d', strtotime($date.'last sunday'));
        echo "<br>";   
        echo "saturday this week : ".date('Y-m-d', strtotime($date.'saturday this week'));
        $sales_period_end =  date('Y-m-d', strtotime($date.'saturday this week'));
        echo "<br>";   

        $settlement_date = date('Y-m-d', strtotime($sales_period_end. ' +1 day'));
        echo "settlement_date =".$settlement_date."<br>";
        
        echo date("Y-m-d", strtotime('sunday last week'));
        echo "<br>";   
        echo date("Y-m-d", strtotime('saturday this week')); echo "<br>";   

        $now = Carbon::now();

        $day = date('w');
        $week_start = date('m-d-Y', strtotime('-'.$day.' days'));
        $week_end = date('m-d-Y', strtotime('+'.(6-$day).' days'));
        echo $week_start." ".$week_end."<br>";

        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');


        echo $weekStartDate." ".$weekEndDate; die;
    }

    public function payoutGenerate()
    {
        $admin_fee_on_dbt_booking = AdminGlobalVariable::where('status', '=', 'active')->where('type','=','admin_fee_on_dbt_booking')->first();
        $admin_fee_on_cc_booking = AdminGlobalVariable::where('status', '=', 'active')->where('type','=','admin_fee_on_cc_booking')->first();

        $hotels = HotelInfo::where('status', '!=', 'deleted')->select(['id','hotel_id'])->get();
        foreach($hotels as $hotel)
        {
            $query = Booking::where('hotel_id', '=', $hotel->hotel_id);
            $query->where('status', '=', 'active');
            $query->where('is_payout_generated', '=', '0');
            $query->whereNested(function($query) {
                $query->where('booking_status', '=', "completed");
                $query->orWhere('booking_status', '=', "cancelled");
            });
            $query->select(['*']);                
            $bookings =  $query->get();
             
            // echo "<pre>"; print_r($bookings); 
            foreach($bookings as $booking)
            {
                /*  echo "last Sunday : ".date('Y-m-d', strtotime($booking->check_out_date.'last sunday'));
                echo "== saturday this week : ".date('Y-m-d', strtotime($booking->check_out_date.'saturday this week'));
                echo "booking id $booking->id <br>"; */ 

                $sales_period_start = date('Y-m-d', strtotime($booking->check_out_date.'last sunday'));
                 
                $sales_period_end =  date('Y-m-d', strtotime($booking->check_out_date.'saturday this week'));
                
                $settlement_date = date('Y-m-d', strtotime($sales_period_end. ' +1 day'));

                $isSalesPeriodExist = Payout::where('sales_period_start', '=', $sales_period_start)->where('sales_period_end', '=', $sales_period_end)->where('hotel_id', '=', $hotel->hotel_id)->select(['*'])->first();  
                
                $admin_fee_on_dbt_booking_value = (isset($admin_fee_on_dbt_booking->value))?$admin_fee_on_dbt_booking->value:0;

                $admin_fee_on_cc_booking_value = (isset($admin_fee_on_cc_booking->value))?$admin_fee_on_cc_booking->value:0;
                
                $commission_rate = ($booking->payment_method == 'credit_card')?$admin_fee_on_cc_booking_value:$admin_fee_on_dbt_booking_value;

                $commission =0;
                $booking_total = $booking->per_night_charges;

                if($booking->booking_status == 'cancelled')
                {
                    $BookingCancelDetail = BookingCancelDetail::where('booking_id', '=', $booking->id)->select(['*'])->first();  
                    $commission = round(($booking_total/100)*$commission_rate);  
                }
                else
                {
                     $commission = round(($booking_total/100)*$commission_rate);         
                }    

                 if($isSalesPeriodExist)
                 {
                    $payoutHistory = PayoutHistory::create([
                        'hotel_id' => $hotel->hotel_id,
                        'payout_id' => $isSalesPeriodExist->id,
                        'booking_id' => $booking->id,
                        'commission_rate' => $commission_rate,
                        'commission' => $commission,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);  

                    if($payoutHistory)
                    {
                        $booking->is_payout_generated = 1;
                        $booking->save(); 
                        $isSalesPeriodExist->no_of_bookings = $isSalesPeriodExist->no_of_bookings+1;
                        $isSalesPeriodExist->sales_amount = $booking_total+$isSalesPeriodExist->sales_amount;
                        $isSalesPeriodExist->payble_amount = $isSalesPeriodExist->payble_amount - $commission;
                        $isSalesPeriodExist->save();

                        $total_payble_payout = Payout::where('hotel_id','=',$hotel->hotel_id)->where('pay_status','=','planned')->sum('payble_amount');
                        $hotel->total_payble_payout = $total_payble_payout;
                        $hotel->save(); 
                    }
                 }
                 else
                 { 
                    $randomId  = rand(1000,9999);
                    $timestamp = Carbon::now()->timestamp;
                    $slug = $timestamp."".$randomId;

                    $newPayout= Payout::create([
                        'hotel_id'=>$hotel->hotel_id,
                        'slug'=>$slug,
                        'sales_period_start' => $sales_period_start,
                        'sales_period_end' => $sales_period_end,
                        'settlement_date' => $settlement_date,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()                        
                    ]);
                    
                    if($newPayout)
                    {
                        $payoutHistory = PayoutHistory::create([
                            'hotel_id' => $hotel->hotel_id,
                            'payout_id' => $newPayout->id,
                            'booking_id' => $booking->id,
                            'commission_rate' => $commission_rate,
                            'commission' => $commission,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                        if($payoutHistory)
                        {
                            $booking->is_payout_generated = 1;
                            $booking->save(); 
                            $newPayout->no_of_bookings = $newPayout->no_of_bookings+1;
                            $newPayout->sales_amount = $booking_total+$newPayout->sales_amount;
                            $newPayout->payble_amount = $newPayout->payble_amount - $commission;
                            $newPayout->save(); 
                            
                            $total_payble_payout = Payout::where('hotel_id','=',$hotel->hotel_id)->where('pay_status','=','planned')->sum('payble_amount');
                            
                            
                            $hotel->total_payble_payout = $total_payble_payout;
                            $hotel->save(); 
                        }
                    }  
                 }
            }
        }
        echo "payouts generated successfully.";
    }

    public function myPayouts(Request $request)
    {
        $hname ='';
        if(auth()->user()->access !='admin')
        {
            $hotel_id = auth()->user()->id;
            $query = Payout::where('hotel_id', '=', $hotel_id);
            $query->select(['*']);
        }
        else
        {
            $query = Payout::join('hotel_info', 'hotel_info.hotel_id', '=', 'payouts.hotel_id');
            $query->where('payouts.id', '!=', 0);

            $hotel_slug = (isset($request->h))?$request->h:0;
            //echo $hotel_slug; die; 
            if($hotel_slug !=0 && $hotel_slug !='')
            {
                $hotelDetail = HotelInfo::where('slug', '=', $hotel_slug)->select(['id','hotel_id','total_payble_payout','hotel_name'])->first();
                
                if($hotelDetail)
                {
                    $hotel_id = $hotelDetail->hotel_id;   
                    $hname = $hotelDetail->hotel_name;    
                    $query->where('payouts.hotel_id', '=', $hotel_id);
                }
            }
            else
            $hotel_id = 0;   
            $query->select(['hotel_info.hotel_name','payouts.*']);        
        }
        
       
        //  echo 'hname =>'.$hname." hotel_id => ".$hotel_id; die; 
        $hotelInfo = HotelInfo::where('status', '=', 'active')->where('hotel_id', '=', $hotel_id)->select(['id','hotel_id','total_payble_payout'])->first();

        if(isset($request->sd) && isset($request->ed) && $request->sd !='' && $request->ed !='')
        {
            $date1=date_create($request->sd);
            $start_date = date_format($date1,"Y-m-d");
            $query = $query->where('sales_period_start', '>=', $start_date);

            $date2=date_create($request->ed);
            $end_date = date_format($date2,"Y-m-d");
            $query = $query->where('sales_period_start', '<=', $end_date);
        }

        if($request->status !='')
        {
            $query->where('pay_status', '=', $request->status);
        }
        
        $query->get();

        $sd = (isset($request->sd) && $request->sd !='')?$request->sd:'';
        $ed = (isset($request->ed) && $request->ed !='')?$request->ed:'';
        $c = (isset($request->c) && $request->c !='')?$request->c:'sales_period_start';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $h = (isset($request->h) && $request->h !='')?$request->h:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        // $dates = (isset($request->dates) && $request->dates !='')?$request->dates:'';
        $query->orderBy($c,$o);
        $list = $query->paginate(8);
        $exportRows = [];

        $todayFullDateTime = date_format(Carbon::now(),"Y-m-d-H-m-s");

        $filename = 'my_payouts_'.$todayFullDateTime;
        $exportRows[0] = ['Sales Period', 'Payment Date','Sales Amount','Payout Amount','Payout Status'];
        for($i=0; $i < count($list); $i++)
        {
            $sales_period_startDate=date_create($list[$i]->sales_period_start);
            $sales_period_start = date_format($sales_period_startDate,"Y-m-d");

            $sales_period_endDate=date_create($list[$i]->sales_period_end);
            $sales_period_end = date_format($sales_period_endDate,"Y-m-d");

            $settlement_dateDate=date_create($list[$i]->settlement_date);
            $settlement_date = date_format($settlement_dateDate,"Y-m-d");

            $exportRows[$i+1] = [$sales_period_start.'-'.$sales_period_end,$settlement_date,$list[$i]->sales_amount,$list[$i]->sales_amount,$list[$i]->pay_status]; 
        }
        //echo "<pre>"; print_r($exportRows); die;
        // echo $hname; die; 
        if(auth()->user()->access =='admin')
        {
            $hotels = HotelInfo::where('status', '!=', 'deleted')->select('id','hotel_id','slug','hotel_name')->get();
            return view('hotel.payout_list')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'hotelInfo'=>$hotelInfo,'sd'=>$sd,'ed'=>$ed,'exportRows'=>$exportRows,'filename'=>$filename,'hotels'=>$hotels,'h'=>$h,'hname'=>$hname]);
        }
        else
        {
            return view('hotel.payout_list')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'hotelInfo'=>$hotelInfo,'sd'=>$sd,'ed'=>$ed,'exportRows'=>$exportRows,'filename'=>$filename]);
        }    
    } 

    public function payoutDetails($slug, Request $request)
    {
        $hotel_id = auth()->user()->id;
        $query = Payout::where('slug', '=', $slug);
        if(auth()->user()->access !='admin')
            $query->where('hotel_id', '=', $hotel_id);    
        $query->select(['*']);
        $payout = $query->first();

        if($payout)
        {   
            $query = PayoutHistory::join('bookings', 'bookings.id', '=', 'payout_history.booking_id');
            $query->join('rooms','rooms.id', '=', 'bookings.room_id');
            $query->where('payout_history.payout_id', '=', $payout->id);
            if(auth()->user()->access !='admin')
                $query->where('payout_history.hotel_id', '=', $hotel_id);
            $query->select(['payout_history.commission_rate','payout_history.commission','payout_history.payble_amount','payout_history.sales_amount','rooms.room_name', 'bookings.*']);
            //$list = $query->get();
            $query->get();

            $c = (isset($request->c) && $request->c !='')?$request->c:'bookings.id';
            $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
            $query->orderBy($c,$o);
            $list = $query->paginate(8);

            $exportRows = [];

            $todayFullDateTime = date_format(Carbon::now(),"Y-m-d-H-m-s");

            $filename = 'payouts_history_'.$todayFullDateTime;
            $exportRows[0] = ['Payout Details',' ',ucwords($payout->pay_status)];
            $exportRows[1] = [];
            $sales_period_startDate=date_create($payout->sales_period_start);
            $sales_period_start = date_format($sales_period_startDate,"Y-m-d");

            $sales_period_endDate=date_create($payout->sales_period_end);
            $sales_period_end = date_format($sales_period_endDate,"Y-m-d");

            $settlement_dateDate=date_create($payout->settlement_date);
            $settlement_date = date_format($settlement_dateDate,"Y-m-d");
            
            $exportRows[2] = ['Sales Period', 'Payment Date','Total Bookings','Sales Amount','Payout Amount'];
            $exportRows[3] = [$sales_period_start.'-'.$sales_period_end,$settlement_date,$payout->no_of_bookings,$payout->sales_amount,$payout->payble_amount];
            $exportRows[4] = [];
            $exportRows[5] = ['Payout History'];
            $exportRows[6] = [];
            $exportRows[7] = ['Booking ID','Room Name','Guest Name', 'Sales Date', 'Cancel Date', 'Check In - Check Out','Sales Amount','Coupon','Discount','Gateway Type','Commission Rate','Commission','Payout Amount','Booking Status'];
            for($i=0; $i < count($list); $i++)
            {
                $sales_dateDate=date_create($list[$i]->sales_date);
                $sales_date = date_format($sales_dateDate,"Y-m-d");

                $check_in_dateDate=date_create($list[$i]->check_in_date);
                $check_in_date = date_format($check_in_dateDate,"Y-m-d");

                $check_out_dateDate=date_create($list[$i]->check_out_date);
                $check_out_date = date_format($check_out_dateDate,"Y-m-d");

                $cancel_dateDate=date_create($list[$i]->cancel_date);
                $cancel_date = date_format($cancel_dateDate,"Y-m-d");

                $payment_method = ucwords(str_replace("_"," ", $list[$i]->payment_method));
                $discount = $list[$i]->long_stay_discount_amount+$list[$i]->additional_discount;
                $exportRows[$i+8] = [$list[$i]->slug,$list[$i]->room_name,$list[$i]->customer_full_name,$check_out_date,$cancel_date,$check_in_date.'-'.$check_out_date,$list[$i]->sales_amount,$list[$i]->coupon_discount_amount,$discount,$payment_method,$list[$i]->commission_rate,$list[$i]->commission,$list[$i]->payble_amount,ucwords($list[$i]->booking_status)]; 
            }
            /* for($i=0; $i < count($list); $i++)
            {
                $sales_period_startDate=date_create($list[$i]->sales_period_start);
                $sales_period_start = date_format($sales_period_startDate,"Y-m-d");

                $sales_period_endDate=date_create($list[$i]->sales_period_end);
                $sales_period_end = date_format($sales_period_endDate,"Y-m-d");

                $settlement_dateDate=date_create($list[$i]->settlement_date);
                $settlement_date = date_format($settlement_dateDate,"Y-m-d");

                $exportRows[$i+1] = [$sales_period_start.'-'.$sales_period_end,$settlement_date,$list[$i]->sales_amount,$list[$i]->sales_amount,$list[$i]->pay_status]; 
            } */
            
            return view('hotel.payout_details')->with(['list'=>$list,'payout'=>$payout,'o'=>$request->o,'c'=>$request->c,'exportRows'=>$exportRows,'filename'=>$filename]);
        }
        else
        {
            return redirect()->route('my-payouts')->with('error_msg','Invalid Payout.');
        }
        // $hotel = Payout::where('slug', '=', $hotel_id)->select(['id','hotel_id','total_payble_payout'])->first();
        

        // 'list'=>$list,
        // ,'q'=>$q,'status'=>$status,'hotel'=>$hotel
        
    }



    public function payoutMarkPaid($id)
    {
        // dd($id,$status);    
        $payout = Payout::where('id', '=', $id)->first();

        if($payout)
        {
            $payout->pay_status = 'paid';
            $payout->save();
            return redirect()->route('my-payouts')->with('success_msg','Payout paid successfully');
        }
        else
            return redirect()->route('customer_management')->with('error_msg','Invalid payout ');

    }
    
}
