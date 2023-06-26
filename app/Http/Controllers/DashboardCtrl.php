<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\HotelInfo;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Payout;

use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Session;
use Illuminate\Support\Facades\Auth;

class DashboardCtrl extends Controller
{
    
    public function index()
    {
        //
    }

    public function dashboard()
    {
        $fullmonthsArr = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $currentDate = date("Y-m-d"); 
        $currentDateTime = date("Y-m-d 00:00:00"); 
        $currentMonth = date("m"); 
        $currentYear = date("Y"); 
        $lastYear =  date("Y",strtotime("-1 year"));
        $secondlastYear =  date("Y",strtotime("-2 year"));
        
        if(auth()->user()->access != 'admin')
        {
            $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
            $whereHotel =array('hotel_id'=>$hotel_id);//  ,$request->field=>$request->val
            $hotel = HotelInfo::where($whereHotel)->first();
                
            $query = Booking::where('hotel_id', '=', $hotel_id);
            $query->where('status', '=', 'active');
            $query->whereNested(function($query) {
                $query->where('booking_status', '=', "on_hold");
                $query->orWhere('booking_status', '=', "confirmed");
                $query->orWhere('booking_status', '=', "cancelled");
            });
            $noOfAllBookings =  $query->count();
 //           if( $noOfAllBookings >0 )
 //           {
                $noOfOnHoldBookings = Booking::where('hotel_id', '=', $hotel_id)->where('booking_status', '=', "on_hold")->where('status', '=', 'active')->count();
                
                $noOfConfirmedBookings = Booking::where('hotel_id', '=', $hotel_id)->where('booking_status', '=', "confirmed")->where('status', '=', 'active')->count();

                $noOfCancelledBookings = Booking::where('hotel_id', '=', $hotel_id)->where('booking_status', '=', "cancelled")->where('status', '=', 'active')->count();

                $checkinsql = Booking::join('rooms','rooms.id', '=', 'bookings.room_id');
                $checkinsql->where('bookings.hotel_id', '=', $hotel_id);
                $checkinsql->where('bookings.status', '=', 'active');
                $checkinsql->where('bookings.check_in_date', '=', $currentDateTime);
                $checkinsql->whereNested(function($checkinsql) {
                    $checkinsql->where('bookings.booking_status', '=', "on_hold");
                    $checkinsql->orWhere('bookings.booking_status', '=', "confirmed");
                });
                $checkinsql->select(['bookings.id','bookings.slug','bookings.customer_full_name','bookings.customer_phone','bookings.customer_notes','rooms.room_name']);
                $checkinsql->get();
                $checkInBookings = $checkinsql->paginate(5);

                $checkoutsql = Booking::join('rooms','rooms.id', '=', 'bookings.room_id');
                $checkoutsql->where('bookings.hotel_id', '=', $hotel_id);
                $checkoutsql->where('bookings.status', '=', 'active');
                $checkoutsql->where('bookings.check_out_date', '=', $currentDateTime);
                $checkoutsql->whereNested(function($checkoutsql) {
                    $checkoutsql->where('bookings.booking_status', '=', "on_hold");
                    $checkoutsql->orWhere('bookings.booking_status', '=', "confirmed");
                });
                $checkoutsql->select(['bookings.id','bookings.slug','bookings.customer_full_name','bookings.customer_phone','bookings.customer_notes','rooms.room_name']);
                $checkoutsql->get();
                $checkOutBookings = $checkoutsql->paginate(5);
                
                // year on year graph
                $YOY = $this->yoy($hotel_id,$secondlastYear, $lastYear, $currentYear);
                // room utilization rate
                $roomUtilizationRate = $this->roomUtilizationRate(0,'','');
                
                $total_revenue = 0;
                if($hotel){
                    $total_revenue = $hotel->total_payble_payout;
                };
                
                return view('hotel.dashboard_after_booking')->with(['hotel'=>$hotel,'noOfAllBookings'=>$noOfAllBookings,'noOfOnHoldBookings'=>$noOfOnHoldBookings,'noOfCancelledBookings'=>$noOfCancelledBookings,'noOfConfirmedBookings'=>$noOfConfirmedBookings,'currentYear'=>$currentYear,'lastYear'=>$lastYear,'secondlastYear'=>$secondlastYear,'checkInBookings'=>$checkInBookings,'checkOutBookings'=>$checkOutBookings,'total_revenue'=>$total_revenue,'YOY'=>$YOY,'roomUtilizationRate'=>$roomUtilizationRate,'currentMonth'=>$currentMonth,'monthString'=>$fullmonthsArr[$currentMonth-1]]);
//            }
//            else
//            {
//                return view('hotel.dashboard')->with(['hotel'=>$hotel]);
//            }
        }
        else
        {
            $query = Booking::where('status', '=', 'active');
            $query->whereNested(function($query) {
                $query->where('booking_status', '=', "on_hold");
                $query->orWhere('booking_status', '=', "confirmed");
                $query->orWhere('booking_status', '=', "cancelled");
            });
            $noOfAllBookings =  $query->count();
           // if
            $noOfOnHoldBookings = Booking::where('booking_status', '=', "on_hold")->where('status', '=', 'active')->count();
            
            $noOfConfirmedBookings = Booking::where('booking_status', '=', "confirmed")->where('status', '=', 'active')->count();

            $noOfCancelledBookings = Booking::where('booking_status', '=', "cancelled")->where('status', '=', 'active')->count();

           $noOfAllBookings = 0;
            $noOfOnHoldBookings = 0;
            
            $noOfConfirmedBookings = 0;

            $noOfCancelledBookings = 0;


            // pie chart
            $bookingPieChart =[['Bookings', 'No.of bookings'],['Confirmed', $noOfConfirmedBookings], ['Canceled', $noOfCancelledBookings],['On hold',  $noOfOnHoldBookings]];

            // year on year graph
            $YOY = $this->yoy(0,$secondlastYear, $lastYear, $currentYear);
            // room utilization rate
            $roomUtilizationRate = $this->roomUtilizationRate(0,'','');
            // echo "<pre>"; print_r($YOY); die;
            return view('admin.dashboard')->with(['bookingPieChart'=>$bookingPieChart,'currentYear'=>$currentYear,'lastYear'=>$lastYear,'secondlastYear'=>$secondlastYear,'YOY'=>$YOY,'roomUtilizationRate'=>$roomUtilizationRate,'currentMonth'=>$currentMonth,'monthString'=>$fullmonthsArr[$currentMonth-1]]);
            
        }
            
    }

    public function yoy($hotel_id=0,$secondlastYear, $lastYear, $currentYear)
    {
        $YOY =[];
        $YOY[0] = ['', $secondlastYear, $lastYear, $currentYear];
        $monthsArr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']; 
        for($month =1; $month <=12; $month++)
        {
            // second last year data month wise
            $monthStr = ($month>9)?$month:"0".$month;
            $payoutdate = $secondlastYear."-".$monthStr."-01 00:00:00";
            $monthLD = date("Y-m-t 00:00:00", strtotime($payoutdate)); //month last date
            $monthFD = date('Y-m-01 00:00:00', strtotime($payoutdate));  // month first date 
            $querySLY =  Payout::where('sales_period_start','>=',$monthFD);
            $querySLY->where('sales_period_start','<=',$monthLD);
            if($hotel_id>0)
            {
                $querySLY->where('hotel_id','=',$hotel_id);
            }
            $totalPayoutSLY = $querySLY->sum('sales_amount');

            // last year data month wise
            $monthStr = ($month>9)?$month:"0".$month;
            $payoutdate = $lastYear."-".$monthStr."-01 00:00:00";
            $monthLD = date("Y-m-t 00:00:00", strtotime($payoutdate)); //month last date
            $monthFD = date('Y-m-01 00:00:00', strtotime($payoutdate));  // month first date 
            $queryLY =  Payout::where('sales_period_start','>=',$monthFD);
            $queryLY->where('sales_period_start','<=',$monthLD);
            if($hotel_id>0)
            {
                $queryLY->where('hotel_id','=',$hotel_id);
            }
            $totalPayoutLY = $queryLY->sum('sales_amount');
            
            // this year data month wise
            $monthStr = ($month>9)?$month:"0".$month;
            $payoutdate = $currentYear."-".$monthStr."-01 00:00:00";
            $monthLD = date("Y-m-t 00:00:00", strtotime($payoutdate)); //month last date
            $monthFD = date('Y-m-01 00:00:00', strtotime($payoutdate));  // month first date 
            $queryTY =  Payout::where('sales_period_start','>=',$monthFD);
            $queryTY->where('sales_period_start','<=',$monthLD);
            if($hotel_id>0)
            {
                $queryTY->where('hotel_id','=',$hotel_id);
            }
            $totalPayoutTY = $queryTY->sum('sales_amount');

            $YOY[$month] = [$monthsArr[$month-1], $totalPayoutSLY, $totalPayoutLY, $totalPayoutTY];
        }
        
        return $YOY;
    }

    public function roomUtilizationRate($hotel_id=0,$month="", $year="")
    {
        // $monthsArr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $currentDate = date("Y-m-d"); // current date
        $currentMonthLD = date("Y-m-t", strtotime($currentDate));  // last date of current month 
        $currentMonthFD = date('Y-m-01');  // first date of current month 

        $startdate = Carbon::createFromFormat('Y-m-d', $currentMonthFD);
        $enddate = Carbon::createFromFormat('Y-m-d', $currentMonthLD);
        
        $period = CarbonPeriod::create($startdate, $enddate);
        // Iterate over the period
        // $i=1;
        $roomUtilizationRate= []; 
        $roomUtilizationRate[0] = ['Date', 'Confirmed', 'On hold'];
        $counter =0; 
        // $no_of_rooms = count($rooms);
        foreach ($period as $date) {
            $theday = $date->format('Y-m-d');
            $formatedDate = $date->format('d');
            $noOfConfirmed = getNoOfRoomsConfirmed($theday, $theday, $hotel_id);
            $noOfOnHold = getNoOfRoomsOnhold($theday, $theday, $hotel_id);
            // echo $noOfConfirmed[0]->count."<br>"; 
            $counter++;
            $roomUtilizationRate[$counter] = [$formatedDate, $noOfConfirmed[0]->count, $noOfOnHold[0]->count];
        }
        return $roomUtilizationRate;
    }

    public function roomUtilizationRateRange(Request $request)
    {  
        if(auth()->user()->access !='admin')
        {
            $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;            
        }
        else
            $hotel_id =0;
        $monthStr = ($request->month>9)?$request->month:"0".$request->month;
        $currentDate = $request->year."-".$monthStr."-01 00:00:00";
        
        // $currentDate = date("Y-m-d"); // current date
        $currentMonthLD = date("Y-m-t", strtotime($currentDate));  // last date of given month 
        $currentMonthFD = date('Y-m-01', strtotime($currentDate));  // first date of given month 

        $startdate = Carbon::createFromFormat('Y-m-d', $currentMonthFD);
        $enddate = Carbon::createFromFormat('Y-m-d', $currentMonthLD);
        
        $period = CarbonPeriod::create($startdate, $enddate);
        // Iterate over the period
        // $i=1;
        $roomUtilizationRate= []; 
        $roomUtilizationRate[0] = ['Date', 'Confirmed', 'On hold'];
        $counter =0; 
        // $no_of_rooms = count($rooms);
        foreach ($period as $date) {
            $theday = $date->format('Y-m-d');
            $formatedDate = $date->format('d');
            $noOfConfirmed = getNoOfRoomsConfirmed($hotel_id, $theday, $theday);
            $noOfOnHold = getNoOfRoomsOnhold($hotel_id, $theday, $theday);
            // echo $noOfConfirmed[0]->count."<br>"; 
            $counter++;
            $roomUtilizationRate[$counter] = [$formatedDate, $noOfConfirmed[0]->count, $noOfOnHold[0]->count];
        }
        return $roomUtilizationRate;
    }

}
