<?php

namespace App\Http\Controllers;

use App\Models\Home;
use Illuminate\Http\Request;
use App\Models\HotelInfo;
use App\Models\HotelFacilities;
use App\Models\HotelFeatures;
use App\Models\Facilities;
use App\Models\Features;
use App\Models\NearestTouristAttractions;
use App\Models\HotelExtraServices;
use App\Models\LongStayDiscount;
use App\Models\HotelPeakSeason;
use App\Models\Rooms;
use App\Models\RoomFacilities;
use App\Models\RoomFeatures;
use App\Models\RatingReview;
use App\Models\MyFavorite;
use App\Models\Booking;
use App\Models\AdminGlobalVariable;
use App\Models\BookingExtraService;
use App\Models\Post;
use App\Models\User;
use App\Models\NotificationSetting;
use DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerNewBookingEmail;
use App\Mail\HotelNewBookingEmail;
use App\Containers\SMS\SmsService;
use Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // SmsService $sms
    {  
        // $sms = new SmsService();
        // $sms->sendSms('8801710000000', 'Test SMS'); 

        $loggedid = (auth()->user())?auth()->user()->id:0;
        $is_marked = "";
        if($loggedid !=0)
        {
              $is_marked =", (SELECT count(id) FROM `my_favorites` WHERE my_favorites.hotel_id = hotel_info.hotel_id AND status ='marked' AND created_by='".$loggedid."' ) AS is_marked_hotel";
        }

        $topRatedSql = HotelInfo::where('hotel_info.status', '=', 'active');
        $topRatedSql->where('hotel_info.completed_percentage', '=', '100');
        $topRatedSql->select(['hotel_info.id','hotel_info.slug','hotel_info.slug','hotel_info.featured_img','hotel_info.hotel_name','hotel_info.rating','hotel_info.reviews']);
        $topRatedSql->get();
        $topRatedSql->orderBy('hotel_info.rating','desc');
        $topRatedHotels = $topRatedSql->paginate(8);

        $min_price =", (SELECT min(standard_price_weekday) FROM `rooms` WHERE rooms.hotel_id = hotel_info.hotel_id AND status ='active') AS room_price";

        //$editorspickSQL = "SELECT hotel_info.id as hi_rid,hotel_info.hotel_id,hotel_info.slug,hotel_info.featured_img,hotel_info.hotel_name,hotel_info.rating,hotel_info.reviews,hotel_info.is_editors_pick,hotel_info.street,hotel_info.city,hotel_info.subrub,hotel_info.pincode $min_price $is_marked FROM `hotel_info` WHERE hotel_info.status = 'active' AND  hotel_info.completed_percentage = '100' AND hotel_info.is_editors_pick ='yes'LIMIT 12 ";
        $editorspickSQL = "SELECT hotel_info.id as hi_rid,hotel_info.hotel_id,hotel_info.slug,hotel_info.featured_img,hotel_info.hotel_name,hotel_info.rating,hotel_info.reviews,hotel_info.is_editors_pick, hotel_info.sido, hotel_info.sigungu $min_price $is_marked FROM `hotel_info` WHERE hotel_info.status = 'active' AND  hotel_info.completed_percentage = '100' AND hotel_info.is_editors_pick ='yes'LIMIT 12 ";
        $editorsHotels = DB::select($editorspickSQL);
          
        for($i=0; $i<count($editorsHotels); $i++)
        {
            $query = HotelFacilities::join('facilities', 'facilities.id', '=', 'hotel_facilities.facilities_id');
            $query->where('facilities.status', '!=', 'deleted');
            $query->where('hotel_facilities.status', '!=', 'deleted');
            $query->where('hotel_facilities.hotel_id', '=', $editorsHotels[$i]->hotel_id);
            $query->select(['facilities.facilities_name', 'hotel_facilities.*']);
            $editorsHotels[$i]->facilities = $query->get();
    
            $query2 = HotelFeatures::join('features', 'features.id', '=', 'hotel_features.features_id');
            $query2->where('features.status', '!=', 'deleted');
            $query2->where('hotel_features.status', '!=', 'deleted');
            $query2->where('hotel_features.hotel_id', '=', $editorsHotels[$i]->hotel_id);
            $query2->select(['features.features_name', 'hotel_features.*']);
            $editorsHotels[$i]->features = $query2->get();
        }
        // echo "<pre>"; print_r($editorsHotels); die; 
        return view('frontend.home')->with(['topRatedHotels'=>$topRatedHotels,'editorsHotels'=>$editorsHotels]);
    }

    public function eventDetail($slug)
    {
        $post = Post::with(['hasImages'])->where('slug', $slug)->first();
        $posts = Post::where('status', 'active')->where('type', 'events')->where('id', '!=', $post->id)->latest()->take(10)->get();
        return view('frontend.event-detail', compact('post', 'posts'));
    }

    public function magazineDetail($slug)
    {
        $magazine = Post::with(['hasImages'])->where('slug', $slug)->first();
        $magazines = Post::where('status', 'active')->where('type', 'magazine')->where('id', '!=', $magazine->id)->latest()->take(10)->get();
        return view('frontend.magazine-detail', compact('magazine', 'magazines'));
    }

    public function seeAllPost($type)
    {
        $posts = Post::where('status', 'active')->where('type', $type)->latest()->paginate(12);
        return view('frontend.see-all-post', compact('posts', 'type'));
    }

    public function hotelList(Request $request)
    {
        // 부대시설 및 특징 가져오기
        $facilities = Facilities::withCount('hasHotels')->where('status', 'active')->get();
        $features = Features::withCount('hasHotels')->where('status', 'active')->get();
        // 요일과 예약 기간 계산
        $dayofweek = (isset($request->checkin_dates))?
            Carbon::createFromFormat('Y-m-d', $request->checkin_dates)->format('w'):
            Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->format('w');
        $startdate = Carbon::createFromFormat('Y-m-d', $request->checkin_dates);
        $enddate = Carbon::createFromFormat('Y-m-d', $request->checkout_dates);
        $difference = $startdate->diff($enddate)->days;
        $currentDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $advanceDays = $currentDate->diff($startdate)->days;

        // 호텔 목록 검색
        $hotelQuery = HotelInfo::with([
            'hasFeaturedImage',
            'hasFacilities' => function($query) use ($request) {
                if (isset($request->facilities) && count(explode(',', $request->facilities)) > 0) {
                    $query->whereIn('facilities_id', explode(',', $request->facilities));
                }
            },
            'hasFeatures' => function($query) use ($request) {
                if (isset($request->features) && count(explode(',', $request->features)) > 0) {
                    $query->whereIn('features_id', explode(',', $request->features));
                }
            },
            // 호텔 방 필터링
            'hasActiveRooms' => function($query) use ($request, $dayofweek) {
                if (isset($request->adult)) {$query->where('maximum_occupancy_adult', '>=', $request->adult);}
                if ($request->child) {$query->where('maximum_occupancy_child', '>=', $request->child);}
                
                if ($dayofweek === 5 || $dayofweek === 6) {
                    if (isset($request->min_price)) {
                        $query->whereBetween('standard_price_weekend', [$request->min_price, $request->max_price]);
                    }
                    $query->orderBy('standard_price_weekend', 'ASC')->latest();
                } else {
                    if (isset($request->min_price)) {
                        $query->whereBetween('standard_price_weekday', [$request->min_price, $request->max_price]);
                    }
                    $query->orderBy('standard_price_weekday', 'ASC')->latest();
                }
            },
            // 장기 숙박 할인 필터링
            'hasLongStayDiscount' => function($query) use ($difference) {
                $query->where('lsd_min_days', '<=', $difference)
                ->where('lsd_max_days', '>=', $difference);
            }
        ])->withCount([
            // 편의시설 필터링
            'hasFacilities' => function($query) use ($request) {
                if (isset($request->facilities) && count(explode(',', $request->facilities)) > 0) {
                    $query->whereIn('facilities_id', explode(',', $request->facilities));
                }
            },
            // 숙소 특징 필터링
            'hasFeatures' => function($query) use ($request) {
                if (isset($request->features) && count(explode(',', $request->features)) > 0) {
                    $query->whereIn('features_id', explode(',', $request->features));
                }
            },
            // 호텔 방 필터링 (카운트)
            'hasActiveRooms' => function($query) use ($request, $dayofweek) {
                if (isset($request->adult)) {$query->where('maximum_occupancy_adult', '>=', $request->adult);}
                if ($request->child) {$query->where('maximum_occupancy_child', '>=', $request->child);}
                if ($dayofweek === 5 || $dayofweek === 6) {
                    if (isset($request->min_price)) {
                        $query->whereBetween('standard_price_weekend', [$request->min_price, $request->max_price]);
                    }
                    $query->orderBy('standard_price_weekend', 'ASC');
                } else {
                    if (isset($request->min_price)) {
                        $query->whereBetween('standard_price_weekday', [$request->min_price, $request->max_price]);
                    }
                    $query->orderBy('standard_price_weekday', 'ASC');
                }
            } 
        ]);
        // 로그인한 사용자의 경우 위시리스트에 저장한 호텔 수 카운트
        if (auth()->user()) {
            $hotelQuery->withCount(['hasMarkedHotel' => function($query){
                $query->where('created_by', auth()->user()->id);
            }]);
        }
//        if (isset($distance)) {
//            $hotelQuery->where(DB::raw($distance), '<', 50);
//        } else {
           

        if (!isset($request->hname) && !isset($request->sido) && !isset($request->sigungu)){
            $hotelQuery->where(function ($query) use ($request){
                $query->Where('hotel_name', 'like', '%' . $request->search . '%')
                    ->orWhere('sido', 'like', '%' . $request->search . '%')
                    ->orWhere('sigungu', 'like', '%' . $request->search . '%');
            });
        }
        else {
          // Handle the hname value to route to hotel-detail if it exists
            if (isset($request->hname)) {
                // Find the hotel with the matching hotel_name
                $hotel = HotelInfo::where('hotel_name', '=', $request->hname)->first();
                if ($hotel) {
                    // If the hotel is found, get its slug and redirect to hotel-detail
                    return redirect()->route('hotel-detail', array_merge(['slug' => $hotel->slug], $request->query()));
                }
            }
            else {
                if(isset($request->sido)){
                    $hotelQuery->where(function ($query) use ($request){
                        $query->Where('sido', '=', $request->sido);
                    });
                }
                elseif(isset($request->sigungu)){
                    $hotelQuery->where(function ($query) use ($request){
                        $query->Where('sigungu', '=', $request->sigungu);
                    });
                }
            }
        }


    //        }
        $hotelQuery->where('completed_percentage', 100);

        $hotelQuery->where('min_advance_reservation', '<=', $advanceDays)
            ->where('max_advance_reservation', '>=', $advanceDays);

        $hotelQuery->where('status', 'active');
        if (isset($request->rating)) {
            $hotelQuery->where(function($query) use ($request){
                $ratings = explode(',', $request->rating);
                if (count($ratings) > 0) {
                    $i = 0;
                    foreach ($ratings as $rating) {
                        if ($i === 0) {
                            $query->where('rating', '>=', $rating);
                        } else {
                            $query->orWhere('rating', '>=', $rating);
                        }
                        $i++;
                    }
                }
            });
        }
        $hotelQuery
            ->having('has_active_rooms_count', '>', 0);
            //->having('has_features_count', '>', 0)
            //->having('has_facilities_count', '>', 0);
        if ($hotelQuery->count() > 0 && isset($request->sort)) {
            $orderByRaw = "";
            if ($dayofweek === 5 || $dayofweek === 6) {
                $orderByRaw = "(SELECT MIN(standard_price_weekend) FROM rooms WHERE rooms.hotel_id = hotel_info.hotel_id AND status ='active')";
            } else {
                $orderByRaw = "(SELECT MIN(standard_price_weekday) FROM rooms WHERE rooms.hotel_id = hotel_info.hotel_id AND status ='active')";
            }
            switch ($request->sort) {
              case 'plth':
                $hotelQuery->orderBY(DB::raw($orderByRaw), 'ASC');
                break;
              case 'phtl':
                $hotelQuery->orderBY(DB::raw($orderByRaw), 'DESC');
                break;
              case 'rahtl':
                $hotelQuery->orderBy('rating', 'DESC');
                break;
              case 'rvhtl':
                $hotelQuery->orderBy('reviews', 'DESC');
                break;
              default:
                $hotelQuery->orderBy('rating', 'DESC');
                break;
            }
        }

        // 호텔 페이지네이션 처리
        $hotels = $hotelQuery->paginate(25);
        // 지도에 표시할 호텔 위치 정보 가져오기
        $hotel_locations = $hotelQuery->get();
        $locations = [];
        foreach ($hotel_locations as $data) {
            $returndata = [
                'label' => $data->hotel_name,
                "lat" => $data->latitude,
                "lng" => $data->longitude,
                "hotelurl" => route('api-data-for-map-pin', $data->slug)
            ];
            array_push($locations, $returndata);
        }
        $jsonLocations = $locations;
        // dd($hotels);
        return view('frontend.hotel_listing', compact('hotels', 'jsonLocations', 'facilities', 'features', 'dayofweek', 'request'));
    }


    // hotel details page 
    public function hotelDetail($slug, Request $request)
    {
        $loggedid = (isset(auth()->user()->id))?auth()->user()->id:0;
        
        $isHotelExist = HotelInfo::where('slug','=',$slug)->where('status','=','active')->count();
        if($isHotelExist !=0)
        {
                      
            $hotel = HotelInfo::with('hasImage')->with('hasAttractions')->with('hasExtraServices')->with('hasLongStayDiscount')->where('slug', '=', $slug)->where('slug', '=', $slug)->first(); // ->with('hasPeakSeasont')->with('hasHotelBankAcDetails')
         
            // check is my favorite hotel 
            $isMyFavorite = MyFavorite::where('hotel_id', '=', $hotel->hotel_id)->where('created_by', '=', $loggedid)->where('status', '=', 'marked')->count();

            if(isset($hotel->latitude) && isset($hotel->longitude) && $hotel->latitude !='' && $hotel->longitude !='')
            {
                $distance = "( '3959' * acos( cos( radians(" . $hotel->latitude . ") ) * cos( radians(`nta_latitude`) ) * cos( radians(`nta_longitude`) - radians(" . $hotel->longitude . ")) + sin(radians(" . $hotel->latitude . ")) * sin( radians(`nta_latitude`))))* 1.609344 as distance";
                $attractions = NearestTouristAttractions::where('hotel_id', $hotel->hotel_id)->where('status','=','active')->select('*', DB::raw($distance))->get();
            }
            else
            {
                $attractions = NearestTouristAttractions::where('hotel_id', $hotel->hotel_id)->where('status','=','active')->select('*')->get();
            }

            //get rating review list
            $RRsql = RatingReview::join('user', 'user.id', '=', 'rating_reviews.created_by');
            $RRsql->where('rating_reviews.status', '=', 'active');
            $RRsql->where('rating_reviews.hotel_id', '=', $hotel->hotel_id);
            $RRsql->select(['user.full_name', 'rating_reviews.*']);
            $RRsql->get();
            $RRsql->orderBy('rating_reviews.id','desc');
            $rating_reviews = $RRsql->paginate(8);
            
            $totalNoOfRating = RatingReview::where('hotel_id', '=', $hotel->hotel_id)->where('status', '=', 'active')->count();
            
            $totalNoOfCleanliness = RatingReview::where('hotel_id', '=', $hotel->hotel_id)->where('status', '=', 'active')->avg('cleanliness');
            
            $totalNoOfFacilities = RatingReview::where('hotel_id', '=', $hotel->hotel_id)->where('status', '=', 'active')->avg('facilities');
            
            $totalNoOfService = RatingReview::where('hotel_id', '=', $hotel->hotel_id)->where('status', '=', 'active')->avg('service');
           
            $totalNoOfValueformoney = RatingReview::where('hotel_id', '=', $hotel->hotel_id)->where('status', '=', 'active')->avg('value_for_money');
                     
            
            if($totalNoOfRating !=0)
            {
                $progressBarCleanliness =  round($totalNoOfCleanliness/0.05);
                $progressBarFacilities =  round($totalNoOfFacilities/0.05);
                $progressBarService =  round($totalNoOfService/0.05);
                $progressBarValueformoney =  round($totalNoOfValueformoney/0.05);
            }
            else
            {
                $progressBarCleanliness= 0;
                $progressBarFacilities= 0;
                $progressBarService= 0;
                $progressBarValueformoney = 0;
            }
           
            $roomEffectivePrice = 'standard_price_weekday';

            if ($request->query('identifier') == "top-rated" || $request->query('identifier') == "recommended" ) {
                $request->checkin_dates = Carbon::today()->format('Y-m-d');
                $request->checkout_dates = Carbon::tomorrow()->format('Y-m-d');
                $request->adult = 2;
                $request->child = 0;
            }

            if(isset($request->checkout_dates)  && isset($request->adult) && isset($request->child) && $request->checkin_dates !='' && $request->checkout_dates !='' && $request->adult !='' && $request->child !='')
            {
                $checkInDay =  Carbon::createFromFormat('Y-m-d', $request->checkin_dates)->format('w');
                $checkOutDay =  Carbon::createFromFormat('Y-m-d', $request->checkout_dates)->format('w');

                $startdate = Carbon::createFromFormat('Y-m-d', $request->checkin_dates);
                $enddate = Carbon::createFromFormat('Y-m-d', $request->checkout_dates);
                $numberOfNights= $enddate->diff($startdate)->format("%a");
                $numberOfNights = ($numberOfNights <=0)?1:$numberOfNights; 

                $lsd = LongStayDiscount::where('status', '=', 'active')->where('hotel_id', '=', $hotel->hotel_id)->where('lsd_min_days', '<=', $numberOfNights)->where('lsd_max_days', '>=', $numberOfNights)->count();
                
                $min_advance_reservation = Carbon::today()->subDay($hotel->min_advance_reservation-1);
                $today = Carbon::today();
                $max_advance_reservation = Carbon::today()->addDays($hotel->max_advance_reservation);
                // echo $today." min_advance_reservation =>".$min_advance_reservation." max_advance_reservation =>".$max_advance_reservation; die; 
                if($numberOfNights >= $hotel->min_advance_reservation && $numberOfNights <= $hotel->max_advance_reservation)
                {
                    $isAnyPS = HotelPeakSeason::where('status', '=', 'active')->where('hotel_id', '=', $hotel->hotel_id)->where('start_date', '<=', $startdate)->where('end_date', '>=', $enddate)->first();
                       
                    // Get room Effective Price
                    if($isAnyPS)
                        $roomEffectivePrice = 'standard_price_peakseason';
                    else if($checkInDay > 4 ) // || $checkOutDay > 4 
                        $roomEffectivePrice = 'standard_price_weekend';   
                
                    // get room list
                    $rooms = Rooms::with('hasImagesActive')->with('hasBedsActive')->where('hotel_id', '=', $hotel->hotel_id)->where('status', '=', 'active')->where('maximum_occupancy_adult', '>=', $request->adult)->where('maximum_occupancy_child', '>=', $request->child)->orderBy($roomEffectivePrice,'asc')->get();
    
                    if($rooms)
                    {
                        for($i=0; $i<count($rooms); $i++)
                        {
                            $rmfquery = RoomFacilities::join('facilities', 'facilities.id', '=', 'room_facilities.facilities_id');
                            $rmfquery->where('facilities.status', '=', 'active');
                            $rmfquery->where('room_facilities.status', '=', 'active');
                            $rmfquery->where('room_facilities.hotel_id', '=', $hotel->hotel_id);
                            $rmfquery->where('room_facilities.room_id', '=', $rooms[$i]->id);
                            $rmfquery->select(['facilities.facilities_name', 'room_facilities.*']);
                            $room_facilities = $rmfquery->get();
                            $rooms[$i]->room_facilities = $room_facilities;
    
                            $rmfquery2 = RoomFeatures::join('features', 'features.id', '=', 'room_features.features_id');
                            $rmfquery2->where('features.status', '=', 'active');
                            $rmfquery2->where('room_features.status', '=', 'active');
                            $rmfquery2->where('room_features.hotel_id', '=', $hotel->hotel_id);
                            $rmfquery2->where('room_features.room_id', '=', $rooms[$i]->id);
                            $rmfquery2->select(['features.features_name', 'room_features.*']);
                            $room_features = $rmfquery2->get();
                            $rooms[$i]->room_features = $room_features;
                            // echo "rooms[$i]->id".$rooms[$i]->id." -- ".$request->checkin_dates." ".$request->checkout_dates."<br>"; 
                            $isRoomBooked = checkIsRoomBooked($rooms[$i]->id, $request->checkin_dates, $request->checkout_dates);
                            $rooms[$i]->isRoomBooked = count($isRoomBooked);
                        }     
                    }
                }
                else{ $rooms =[]; } 
            }
            else
            {
                $lsd = 0;
                $rooms =[];
            }

           
            // get hotel facilities 
            $hotel_facilities_query = HotelFacilities::join('facilities', 'facilities.id', '=', 'hotel_facilities.facilities_id');
            $hotel_facilities_query->where('facilities.status', '!=', 'deleted');
            $hotel_facilities_query->where('hotel_facilities.status', '!=', 'deleted');
            $hotel_facilities_query->where('hotel_facilities.hotel_id', '=', $hotel->hotel_id);
            $hotel_facilities_query->select(['facilities.facilities_name', 'hotel_facilities.*']);
            $hotel_facilities = $hotel_facilities_query->get();
    
            // get hotel feature
            $hotel_features_query = HotelFeatures::join('features', 'features.id', '=', 'hotel_features.features_id');
            $hotel_features_query->where('features.status', '!=', 'deleted');
            $hotel_features_query->where('hotel_features.status', '!=', 'deleted');
            $hotel_features_query->where('hotel_features.hotel_id', '=', $hotel->hotel_id);
            $hotel_features_query->select(['features.features_name', 'hotel_features.*']);
            $hotel_features = $hotel_features_query->get();

            $locations = [];
            foreach ($attractions as $data) {
                $returndata = [
                    'label' => $data->attractions_name,
                    "lat" => $data->nta_latitude,
                    "lng" => $data->nta_longitude
                ];
                array_push($locations, $returndata);
            }
            $jsonLocations = $locations;
           
            // echo "<pre>"; print_r($rooms[0]->room_facilities); echo "</pre>"; die; 
            return view('frontend.hotel_details')->with(['hotel'=>$hotel,'hotel_facilities'=>$hotel_facilities,'hotel_features'=>$hotel_features,'rating_reviews'=>$rating_reviews,'rooms'=>$rooms,'attractions'=>$attractions,'isMyFavorite'=>$isMyFavorite,'jsonLocations'=>$jsonLocations,'lsd'=>$lsd,'roomEffectivePrice'=>$roomEffectivePrice,'totalNoOfRating'=>$totalNoOfRating,'progressBarCleanliness'=>$progressBarCleanliness,'progressBarFacilities'=>$progressBarFacilities,'progressBarValueformoney'=>$progressBarValueformoney,'progressBarService'=>$progressBarService]);
        }
        else
            return redirect()->route('home');
    }

    // load term and conditions page
    public function term_and_conditions()
    {
        return view('frontend.term_and_condition');
    }
    
    // load privacy policy page
    public function privacy_policy()
    {
        return view('frontend.privacy_policy');
    }

    // Room checkout page 
    public function roomCheckout(Request $request)
    {
        // dd($request);
        $no_of_week_days = 0;
        $no_of_weekend_days = 0;
        $no_of_peakseason_days = 0;
         
        if(!auth()->user() || (auth()->user() && auth()->user()->access=='customer'))
        {
            if(isset($request->h) && isset($request->r)  && isset($request->checkin_dates)  && isset($request->checkout_dates)  && isset($request->adult) && isset($request->child) && $request->h !='' && $request->r !='' && $request->checkin_dates !='' && $request->checkout_dates !='' && $request->adult !='' && $request->child !='')
            {
                if($request->session()->get('customer_phone') !='')
                {
                    $customer_phone = $request->session()->get('customer_phone');
                    $customer_email = $request->session()->get('customer_email');
                    $customer_full_name = $request->session()->get('customer_full_name');
                    $customer_notes = $request->session()->get('customer_notes');
                }
                else if(auth()->user() && auth()->user()->access=='customer')
                {
                    $customer_phone = auth()->user()->phone;
                    $customer_email = auth()->user()->email;
                    $customer_full_name = auth()->user()->full_name;
                    $customer_notes = '';
                }
                else
                {
                    $customer_phone = '';
                    $customer_email = '';
                    $customer_full_name = '';
                    $customer_notes = '';
                }
                
                $hotel = HotelInfo::with('hasExtraServices')->where('status', '=', 'active')->where('slug', '=', $request->h)->first();
                if($hotel)
                {
                    if($request->session()->get('es_charges') !='' && $request->session()->get('es_charges') !=null)
                        $es_charges = $request->session()->get('es_charges');
                    else
                        $es_charges = 0;
                    // Extra Services Charges
                    if($request->session()->get('extra_services') !='' && $request->session()->get('extra_services') !=null)
                    $BookingExtraService = HotelExtraServices::where('hotel_id', '=', $hotel->hotel_id)->whereIn('id', $request->session()->get('extra_services'))->where('status', '=', 'active')->get();
                    else
                    $BookingExtraService =[];
                    // dd($BookingExtraService[1]->id);
                    $hotel_id = $hotel->hotel_id;
                    $checkInDay =  Carbon::createFromFormat('Y-m-d', $request->checkin_dates)->format('w');
                    $checkOutDay =  Carbon::createFromFormat('Y-m-d', $request->checkout_dates)->format('w');
                   
                    $startdate = Carbon::createFromFormat('Y-m-d', $request->checkin_dates);
                    $enddate = Carbon::createFromFormat('Y-m-d', $request->checkout_dates);
                    $numberOfNights= $enddate->diff($startdate)->format("%a");
                    $numberOfNights = ($numberOfNights <=0)?1:$numberOfNights; 
                    $newEnddate = date('Y-m-d', strtotime($enddate. ' -0 day'));
                    //  echo $newEnddate."<br>";
                    if($startdate != $enddate)
                       $period = CarbonPeriod::create($startdate, $newEnddate);
                    else
                        $period = CarbonPeriod::create($startdate, $enddate);  
                    // Iterate over the period
                    $i=1;
                    foreach ($period as $date) {
                        //$date->format('Y-m-d')
                        // echo $i.". ".$date->format('Y-m-d').'----';
                        $thedate = $date->format('Y-m-d');
                        $theday =  Carbon::createFromFormat('Y-m-d', $date->format('Y-m-d'))->format('w');
                        $thisDateIsPeakSeason = thisDateIsPeakSeason($hotel_id, $thedate);
                        if(count($thisDateIsPeakSeason) > 0)
                            $no_of_peakseason_days++;
                        elseif($theday > 4)
                            $no_of_weekend_days++;
                        else
                           $no_of_week_days++;
                        // echo $theday."<br>";
                        $i++;
                    }
                    //  echo $no_of_weekend_days." -- ".$no_of_week_days." -- ".$no_of_peakseason_days." ---- ".$numberOfNights; 
                    // die; 
                    $room = Rooms::where('hotel_id', '=', $hotel_id)->where('slug', '=', $request->r)->where('status', '=', 'active')->where('maximum_occupancy_adult', '>=', $request->adult)->where('maximum_occupancy_child', '>=', $request->child)->first();
                    if($room)
                    {
                        // check is there any long stay discout 
                        $lsd = LongStayDiscount::where('status', '=', 'active')->where('hotel_id', '=', $hotel_id)->where('lsd_min_days', '<=', $numberOfNights)->where('lsd_max_days', '>=', $numberOfNights)->first();
                        // Check is there is any peak-season b/w check-in & checkout date
                        $isAnyPS = HotelPeakSeason::where('status', '=', 'active')->where('hotel_id', '=', $hotel_id)->where('start_date', '<=', $startdate)->where('end_date', '>=', $enddate)->first();
                       
                        // Get room Effective Price
                        /* if($isAnyPS)
                        {
                            $roomEffectivePrice = $room->standard_price_peakseason;
                        }
                        else if($checkInDay > 4)  //  || $checkOutDay > 4 
                        {
                            $roomEffectivePrice = $room->standard_price_weekend;   
                        }
                        else
                        {
                            $roomEffectivePrice = $room->standard_price_weekday;
                        } */

                        $cAges = [];
                        // get no. of child who are yealder from 3 year
                        $noOfChild3YearPlus =0;
                        if(isset($request->cages) && $request->cages !='')
                        {
                            $cAges = explode(",",$request->cages);
                        }  
                        $childInfo="<div class='tooltipbox'>";                                                                                             
                        /* if(count($cAges))
                        {
                            $childInfo="<div class='tooltipbox'>";
                            for($i=0; $i < count($cAges); $i++)
                            {
                                $c = $i+1;
                                if($cAges[$i] >= 3)
                                $noOfChild3YearPlus++;
                                if($i == 0)
                                $childInfo = $childInfo."<span class='normalfont'>Child $c: <small class='mediumfont'>$cAges[$i]yrs</small></span>";
                                else
                                $childInfo = $childInfo.", <span class='normalfont'>Child $c: <small class='mediumfont'>$cAges[$i]yrs</small></span>";   
                            } 
                            $childInfo .="</div>";
                        } */
                        
                        /*   
                        $extraAdult = ($room->standard_occupancy_adult < $request->adult)?$request->adult-$room->standard_occupancy_adult:0;
                        
                        $extraChild = ($room->standard_occupancy_adult < $request->child)?$request->child-$room->standard_occupancy_adult:0;

                        if($extraChild !=0 && $extraChild > $noOfChild3YearPlus)
                            $extraChild = $noOfChild3YearPlus;

                        $noOfExtraGuest = $extraAdult + $extraChild;
                        */ 

                        $no_of_childs  = 0;
                        if(isset($request->childs_below_nyear) && $request->childs_below_nyear !='' && $request->childs_below_nyear > 0)
                        {
                            $no_of_childs  += $request->childs_below_nyear;
                            $childInfo .="<span class='normalfont'>Child < 3years: <small class='mediumfont'>$request->childs_below_nyear</small></span>";
                        }    
                        
                        if(isset($request->childs_plus_nyear) && $request->childs_plus_nyear !='' && $request->childs_plus_nyear > 0)
                        {
                            $no_of_childs  += $request->childs_plus_nyear;
                            $comma = ($request->childs_below_nyear > 0)?',':'';
                            $childInfo .=" $comma <span class='normalfont'>Child > 3years: <small class='mediumfont'>$request->childs_plus_nyear</small></span>";
                        }
                        
                        $childInfo .="</div>";

                        $extraAdult = ($request->adult > $room->standard_occupancy_adult)?$request->adult - $room->standard_occupancy_adult:0;
                        
                        $extraChild = 0; 
                        if($no_of_childs > $room->standard_occupancy_child)
                        {
                            $extraChild = $no_of_childs - $room->standard_occupancy_child;
                
                            $extraChild  = ($extraChild <= $request->childs_plus_nyear)?$extraChild:0;
                        }

                        $noOfExtraGuest = $extraAdult + $extraChild;

                        $roomStandardCharges = round($no_of_peakseason_days * $room->standard_price_peakseason) + round($no_of_weekend_days * $room->standard_price_weekend) + round($no_of_week_days * $room->standard_price_weekday);     
                        if($noOfExtraGuest !=0)
                            $ExtraGuestCharges = round(($noOfExtraGuest*$room->extra_guest_fee*$numberOfNights));   
                        else       
                            $ExtraGuestCharges = 0;

                        // price breck 
                        $pbTotal = $roomStandardCharges + $ExtraGuestCharges; // $roomStandardCharges     
                            
                        if($lsd)
                        {   
                            if($lsd->lsd_discount_type =='flat')
                                $lsdAmount = $lsd->lsd_discount_amount;
                            else
                                $lsdAmount = round(($pbTotal/100)*$lsd->lsd_discount_amount,2);          
                        }
                        else
                            $lsdAmount = 0; 

                        $cpnAmount  =0;  
    
                        if($request->session()->has('coupon_code_name') && $request->session()->has('couponAppliedH') )    
                        {
                            if($request->session()->get('couponAppliedH') == $request->h)    
                            {
                                 if($request->session()->get('discount_type')=='percentage')
                                 {
                                    $discountAmount =  (float) $request->session()->get('discount_amount');
                                    $max_discount_amount =  (float) $request->session()->get('max_discount_amount');
                                    $cpnAmount = round(($pbTotal/100)*$discountAmount,2);
                                    if($max_discount_amount > $cpnAmount)
                                        $cpnAmount = $max_discount_amount;
                                 }
                                 else
                                 {
                                    $cpnAmount = $request->session()->get('discount_amount');
                                 }
                            }
                            else
                            {
                                $request->session()->forget('coupon_code_name');
                                $request->session()->forget('couponAppliedH');
                                $request->session()->forget('discount_type');
                                $request->session()->forget('discount_amount');
                                $request->session()->forget('max_discount_amount');
                            }   
                        }
                                
                        $pbTotal = $pbTotal - $lsdAmount;
                        $pbTotal = $pbTotal - $cpnAmount;

                        if($pbTotal < 0)
                            $pbTotal =0;
                        
                        if($no_of_peakseason_days > 0 || $no_of_weekend_days > 0 || $no_of_week_days > 0)    
                            $nightChargesInfo ="<div class='tooltipbox'>";
                        else
                            $nightChargesInfo ="";

                        if($no_of_peakseason_days > 0)
                            $nightChargesInfo .="<p class='normalfont mb-0'>Peak Season: <small class='mediumfont'>$no_of_peakseason_days x $room->standard_price_peakseason </small></p>";

                        if($no_of_weekend_days > 0)
                            $nightChargesInfo .="<p class='normalfont mb-0'>Week-End(s): <small class='mediumfont'>$no_of_weekend_days x $room->standard_price_weekend </small></p>";
                            
                        if($no_of_week_days > 0)
                            $nightChargesInfo .="<p class='normalfont mb-0'>Week-Day(s): <small class='mediumfont'>$no_of_week_days x $room->standard_price_weekday </small></p>";    

                        if($no_of_peakseason_days > 0 || $no_of_weekend_days > 0 || $no_of_week_days > 0)
                            $nightChargesInfo .="</div>";

                        return view('frontend.room_checkout')->with(['hotel'=>$hotel,'room'=>$room,'request'=>$request,'lsd'=>$lsd,'noOfExtraGuest'=>$noOfExtraGuest,'noOfExtraGuest'=>$noOfExtraGuest,'cAges'=>$cAges,'childInfo'=>$childInfo,'numberOfNights'=>$numberOfNights,'ExtraGuestCharges'=>$ExtraGuestCharges,'pbTotal'=>$pbTotal,'lsdAmount'=>$lsdAmount,'cpnAmount'=>$cpnAmount,'customer_phone'=>$customer_phone,'customer_email'=>$customer_email,'customer_full_name'=>$customer_full_name,'customer_notes'=>$customer_notes,'BookingExtraService'=>$BookingExtraService,'es_charges'=>$es_charges,'no_of_childs'=>$no_of_childs,'no_of_week_days'=>$no_of_week_days,'no_of_weekend_days'=>$no_of_weekend_days,'no_of_peakseason_days'=>$no_of_peakseason_days,'standard_price_peakseason'=>$room->standard_price_peakseason,'standard_price_weekend'=>$room->standard_price_weekend,'standard_price_weekday'=>$room->standard_price_weekday,'roomStandardCharges'=>$roomStandardCharges,'nightChargesInfo'=>$nightChargesInfo]);
                    }
                    else 
                    {
                        return redirect()->route('home');
                    } 
                }
                else 
                {
                    return redirect()->route('home');
                }
        
            }            
            else 
            {
                return redirect()->route('home');
            }    
        }
        else 
        {
            return redirect()->route('home');
        }   
    }

    // 
    public function confirmBooking(Request $request)
    {
        $hotel = HotelInfo::where('slug', '=', $request->h)->where('status', '=', 'active')->first();

        if($hotel)
        {
            $room = Rooms::where('slug', '=', $request->r)->where('status', '=', 'active')->where('maximum_occupancy_adult', '>=', $request->adults)->where('maximum_occupancy_child', '>=', $request->childs)->first();

            if($room)
            {
                // dd($request->check_in_date.'--'.$request->check_out_date);
                /* $sql = "SELECT * FROM `bookings` WHERE room_id = '".$room->id."' AND ((check_in_date = '".$request->check_in_date."' || check_out_date ='".$request->check_out_date."') || (check_in_date >= '".$request->check_in_date."' && check_in_date <='".$request->check_out_date."')  || (check_out_date >= '".$request->check_in_date."' && check_out_date <='".$request->check_out_date."') || (check_in_date >= '".$request->check_in_date."' && check_in_date <='".$request->check_in_date."') || (check_in_date <= '".$request->check_in_date."' && check_out_date >='".$request->check_out_date."') || (check_in_date <= '".$request->check_out_date."' && check_out_date >='".$request->check_out_date."'))";
                $isRoomBooked = DB::select($sql); */
                $isRoomBooked = checkIsRoomBooked($room->id, $request->check_in_date, $request->check_out_date);

                // $data = ['status' => 0, 'message'=>'test','data'=>$isRoomBooked,'sql'=>$sql];
                // return response()->json($data);

               // dd($sql);
                if(count($isRoomBooked) ==0)
                {
                    $request->session()->put('check_in_date', $request->check_in_date);
                    $request->session()->put('check_out_date', $request->check_out_date);
                    $request->session()->put('adult', $request->adults);
                    $request->session()->put('child', $request->childs);
                    $request->session()->put('childs_below_nyear', $request->childs_below_nyear);
                    $request->session()->put('childs_plus_nyear', $request->childs_plus_nyear);
                    if(isset($request->cages) && $request->cages)
                    $request->session()->put('child_ages', $request->cages);
            
                    $request->session()->put('noOfExtraGuest', $request->noOfExtraGuest);
                    $request->session()->put('numberOfNights', $request->numberOfNights);
                    $request->session()->put('roomStandardCharges', $request->roomStandardCharges);
                    $request->session()->put('ExtraGuestCharges', $request->ExtraGuestCharges);
                    $request->session()->put('cpnAmount', $request->cpn_total);
                    $request->session()->put('lsdAmount', $request->lsd_total);
                    $request->session()->put('pbTotal', $request->grand_total);
            
                    $request->session()->put('customer_full_name', $request->full_name);
                    $request->session()->put('customer_phone', $request->phone);
                    $request->session()->put('customer_email', $request->email);
                    $request->session()->put('customer_notes', $request->notes);
                    
                    $request->session()->put('h', $request->h);
                    $request->session()->put('r', $request->r);
                    
                    $request->session()->put('extra_services', $request->extra_services);
                    $request->session()->put('es_qty', $request->es_qty);
                    $request->session()->put('es_charges', $request->es_charges);

                    
                    $request->session()->put('no_of_week_days', $request->no_of_week_days);
                    $request->session()->put('standard_price_weekday', $request->standard_price_weekday);
                    $request->session()->put('no_of_weekend_days', $request->no_of_weekend_days);
                    $request->session()->put('standard_price_weekend', $request->standard_price_weekend);
                    $request->session()->put('no_of_peakseason_days', $request->no_of_peakseason_days);
                    $request->session()->put('standard_price_peakseason', $request->standard_price_peakseason);
            
                    $nextpageurl = route('room-payment');
                    $data = ['status' => 1, 'message'=>'','nextpageurl'=>$nextpageurl];
                    return response()->json($data);    
                }
                else
                {
                    $data = ['status' => 0, 'message'=>'This room is already booked on same dates.','nextpageurl'=>''];
                    return response()->json($data);
                } 
                // dd($request);
                
            }
            else
            {
                $data = ['status' => 0, 'message'=>'This room is now not available.','nextpageurl'=>''];
                return response()->json($data);
            }    
        }
        else
        {
            $data = ['status' => 0, 'message'=>'This hotel is now not available.','nextpageurl'=>''];
            return response()->json($data);
        }
    }



    // Room payment pay page 
    public function roomPayment(Request $request)
    {
        if($request->session()->get('h') !='')
        {
            // print_r($request->session()->get('extra_services')); 
            // dd($request->session()->get('es_qty'));
            $hotel_slug = $request->session()->get('h'); 
            $room_slug = $request->session()->get('r'); 
            $hotel = HotelInfo::with('hasExtraServices')->where('status', '=', 'active')->where('slug', '=', $hotel_slug)->first();
            if($hotel)
            {
                if($request->session()->get('es_charges') !='' && $request->session()->get('es_charges') !=null)
                   $es_charges = $request->session()->get('es_charges');
                else
                    $es_charges = 0;
                // Extra Services Charges
                if($request->session()->get('extra_services') !='' && $request->session()->get('extra_services') !=null)
                $BookingExtraService = HotelExtraServices::where('hotel_id', '=', $hotel->hotel_id)->whereIn('id', $request->session()->get('extra_services'))->where('status', '=', 'active')->get();
                else
                $BookingExtraService =[];
                // echo "<pre>"; print_r($BookingExtraService); echo "</pre>";
                // echo "<pre>"; print_r($request->session()->get('extra_services')); echo "</pre>";
                // echo "<pre>"; print_r($request->session()->get('es_qty')); echo "</pre>";
                // die;
                // dd($BookingExtraService,$request->session()->get('extra_services'),$request->session()->get('es_qty'));
                $points_earn_on_booking = AdminGlobalVariable::where('status', '=', 'active')->where('type','=','points_earn_on_booking')->first();
                $points_conversion_rate = AdminGlobalVariable::where('status', '=', 'active')->where('type','=','points_conversion_rate')->first();
                $min_required_points_for_redeem_points = AdminGlobalVariable::where('status', '=', 'active')->where('type','=','min_required_points_for_redeem_points')->first();

                $standard_price_peakseason = $request->session()->get('standard_price_peakseason');
                $standard_price_weekend = $request->session()->get('standard_price_weekend');
                $standard_price_weekday = $request->session()->get('standard_price_weekday');
                $no_of_week_days = $request->session()->get('no_of_week_days');
                $no_of_weekend_days = $request->session()->get('no_of_weekend_days');
                $no_of_peakseason_days = $request->session()->get('no_of_peakseason_days');

                if($no_of_peakseason_days > 0 || $no_of_weekend_days > 0 || $no_of_week_days > 0)    
                $nightChargesInfo ="<div class='tooltipbox'>";
                else
                    $nightChargesInfo ="";

                if($no_of_peakseason_days > 0)
                    $nightChargesInfo .="<p class='normalfont mb-0'>Peak Season: <small class='mediumfont'>$no_of_peakseason_days x $standard_price_peakseason </small></p>";

                if($no_of_weekend_days > 0)
                    $nightChargesInfo .="<p class='normalfont mb-0'>Week-End(s): <small class='mediumfont'>$no_of_weekend_days x $standard_price_weekend </small></p>";
                    
                if($no_of_week_days > 0)
                    $nightChargesInfo .="<p class='normalfont mb-0'>Week-Day(s): <small class='mediumfont'>$no_of_week_days x $standard_price_weekday </small></p>";    

                if($no_of_peakseason_days > 0 || $no_of_weekend_days > 0 || $no_of_week_days > 0)
                    $nightChargesInfo .="</div>";

                $myPoints = (isset(auth()->user()->total_rewards_points))?auth()->user()->total_rewards_points:0;
                    $nightChargesInfo .="</div>";
                return view('frontend.room_payment')->with(['hotel'=>$hotel,'room_slug'=>$room_slug,'check_in_date'=>$request->session()->get('check_in_date'),'check_out_date'=>$request->session()->get('check_out_date'),'adult'=>$request->session()->get('adult'),'child'=>$request->session()->get('child'),'childs_below_nyear'=>$request->session()->get('childs_below_nyear'),'childs_plus_nyear'=>$request->session()->get('childs_plus_nyear'),'myPoints'=>$myPoints,'noOfExtraGuest'=>$request->session()->get('noOfExtraGuest'),'numberOfNights'=>$request->session()->get('numberOfNights'),'roomStandardCharges'=>$request->session()->get('roomStandardCharges'),'ExtraGuestCharges'=>$request->session()->get('ExtraGuestCharges'),'cpnAmount'=>$request->session()->get('cpnAmount'),'lsdAmount'=>$request->session()->get('lsdAmount'),'pbTotal'=>$request->session()->get('pbTotal'),'customer_full_name'=>$request->session()->get('customer_full_name'),'customer_email'=>$request->session()->get('customer_email'),'customer_phone'=>$request->session()->get('customer_phone'),'customer_notes'=>$request->session()->get('customer_notes'),'coupon_code_name'=>$request->session()->get('coupon_code_name'),'min_required_points_for_redeem_points'=>$min_required_points_for_redeem_points,'points_conversion_rate'=>$points_conversion_rate,'points_earn_on_booking'=>$points_earn_on_booking,'cages'=>$request->session()->get('child_ages'),'BookingExtraService'=>$BookingExtraService,'es_charges'=>$es_charges,'request'=>$request,'nightChargesInfo'=>$nightChargesInfo]);
            }
        }
        else
        {
            return redirect()->route('home');
        }    
    }

    // Booking Payment  Direct bank transfer 
    public function directBankTransferSubmit(Request $request)
    {
        // dd($request);
        $per_night_charges = (float) $request->session()->get('roomStandardCharges');  
        // echo $per_night_charges; die;
        $randomId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $slug = $timestamp."".$randomId;
        
        $hotel_slug = $request->session()->get('h'); 
        $room_slug = $request->session()->get('r'); 
        $hotel = HotelInfo::where('status', '=', 'active')->where('slug', '=', $hotel_slug)->first();
        $customer_notes = '';
        if($request->session()->get('customer_notes') !='' || $request->session()->get('customer_notes')!=null)
            $customer_notes = $request->session()->get('customer_notes');

        $coupon_code_name = '';
        if($request->session()->get('coupon_code_name') !='' || $request->session()->get('coupon_code_name')!=null)
            $coupon_code_name = $request->session()->get('coupon_code_name');
        
        $applied_discount_amount = 0;
        if($request->session()->get('applied_discount_amount') !='' || $request->session()->get('applied_discount_amount')!=null)
            $applied_discount_amount = $request->session()->get('applied_discount_amount');    
        
        $child_ages ='';
        if($request->session()->get('child_ages') !='' || $request->session()->get('child_ages')!=null)
            $child_ages = $request->session()->get('child_ages');

        if($request->session()->get('es_charges') !='' && $request->session()->get('es_charges') !=null)
            $es_charges = $request->session()->get('es_charges');
        else
             $es_charges = 0;    
        
        // dd('$child_ages'.$child_ages."--".$request->session()->get('child_ages'));
        if($hotel)
        {
            $cancellation_policy  = ['same_day_refund'=>$hotel->same_day_refund,'b4_1day_refund'=>$hotel->b4_1day_refund,'b4_2days_refund'=>$hotel->b4_2days_refund,'b4_3days_refund'=>$hotel->b4_3days_refund,'b4_4days_refund'=>$hotel->b4_4days_refund,'b4_5days_refund'=>$hotel->b4_5days_refund,'b4_6days_refund'=>$hotel->b4_6days_refund,'b4_7days_refund'=>$hotel->b4_7days_refund,'b4_8days_refund'=>$hotel->b4_8days_refund,'b4_9days_refund'=>$hotel->b4_9days_refund,'b4_10days_refund'=>$hotel->b4_10days_refund];
            // dd($cancellation_policy); 
            $room = Rooms::where('status', '=', 'active')->where('slug', '=', $room_slug)->first();
            $customer_id = (auth()->user() && auth()->user()->id)?auth()->user()->id:0;
            $newBooking = Booking::create([
                'slug' => $slug,
                'hotel_id' => $hotel->hotel_id,
                'room_id' => $room->id,
                'customer_id' => $customer_id,
                'check_in_date' => $request->session()->get('check_in_date'),
                'check_out_date' => $request->session()->get('check_out_date'),
                'customer_full_name' => $request->session()->get('customer_full_name'),
                'customer_phone' => $request->session()->get('customer_phone'),
                'customer_email' => $request->session()->get('customer_email'),
                'customer_notes' => $customer_notes,
                'no_of_adults' => $request->session()->get('adult'),
                'no_of_childs' => $request->session()->get('child'),
                'childs_below_nyear' => $request->session()->get('childs_below_nyear'),
                'childs_plus_nyear' => $request->session()->get('childs_plus_nyear'),
                'no_of_extra_guest' => $request->session()->get('noOfExtraGuest'),
                'no_of_nights' => $request->session()->get('numberOfNights'),
                'child_ages' => $child_ages,
                'per_night_charges' => $per_night_charges, //  $request->session()->get('roomStandardCharges'),
                'extra_guest_charges' => $request->session()->get('ExtraGuestCharges'),
                'coupon_code' => $coupon_code_name,
                'coupon_discount_amount' => $applied_discount_amount,
                'long_stay_discount_amount' => $request->session()->get('lsdAmount'),
                'reward_points_used' => (int) $request->used_points,
                'payment_by_currency' => (float) $request->pb_total,
                'payment_by_points' => (int) $request->used_points,
                'booking_status' => 'on_hold',
                'payment_status' => 'waiting',
                'payment_method' => 'direct_bank_transfer',
                'cancellation_policy'=>json_encode($cancellation_policy),
                'extra_services_charges'=>$es_charges,
                'total_price'=>$request->session()->get('pbTotal'),
                'peakseason_price' => $request->session()->get('standard_price_peakseason'),
                'weekend_price' => $request->session()->get('standard_price_weekend'),
                'weekday_price' => $request->session()->get('standard_price_weekday'),
                'no_of_weekdays' => $request->session()->get('no_of_week_days'),
                'no_of_weekenddays' => $request->session()->get('no_of_weekend_days'),
                'no_of_peakseason_days' => $request->session()->get('no_of_peakseason_days'),
                'status'=>'active',
                'created_by' => $customer_id,
                'updated_by' => $customer_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            if($newBooking)
            {
                $customer_email_data = [
                    'name' => $request->session()->get('customer_full_name')
                ];

                Mail::to($request->session()->get('customer_email'))->send(new CustomerNewBookingEmail($customer_email_data));


                // email notification sent to hotel if hotel set yes for email notification
                $hotelNS = NotificationSetting::where('status', '=', 'active')->where('user_id', '=', $hotel->hotel_id)->select(['*'])->first();
                if($hotelNS)
                {
                    if($hotelNS->booking_on_hold_email == 1)
                    {
                        $hotelEmail = User::where('id', '=', $hotel->hotel_id)->select(['email'])->first();
                        $hotel_email_data = [
                            'name' => $hotel->hotel_name
                        ];
                        Mail::to($hotelEmail->email)->send(new HotelNewBookingEmail($hotel_email_data));
                    }
                }
                 // push notification sent to hotel
                 sendNotification($hotel->hotel_id,$message="You are reciving a new booking please  confirm booking.",$newBooking->id);

                // push notification sent to customer if customer is logged in
                if($customer_id !=0)
                    sendNotification($customer_id,$message="Your booking is successfully placed & with on-hold status waiting for payment confirmation.",$newBooking->id);
                
                if($customer_id !=0 && $request->used_points !=0)
                {
                    $used_points = (int) $request->used_points;  
                    updateRewards($used_points,$customer_id,'debited','Reward Redeem','You redeem reward points for booking','active',$slug,'',$customer_id);
                    // $user = User::where('id', '=', $customer_id)->first();
                }
                

                $esQtyArr = $request->session()->get('es_qty'); 
                $selectedESArr = $request->session()->get('extra_services'); 
                if($request->session()->get('extra_services') !='' && $request->session()->get('extra_services') !=null)
                {
                    for($es=0; $es<count($selectedESArr); $es++)
                    {
                        $extraService = HotelExtraServices::where('id', '=', $selectedESArr[$es])->first();
                        $newBookingES = BookingExtraService::create([
                            'booking_id' => $newBooking->id,
                            'es_id'=>$extraService->id,
                            'price'=>$extraService->es_price,
                            'qty'=>$esQtyArr[$es],
                            'es_row_total'=>$esQtyArr[$es]*$extraService->es_price,
                            'status'=>'active',
                            'created_by' => $customer_id,
                            'updated_by' => $customer_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    }    
                }    
                
                $request->session()->forget(['check_in_date', 'check_out_date','customer_full_name','customer_phone','customer_phone','customer_email','customer_notes','adult','child','noOfExtraGuest','numberOfNights','ExtraGuestCharges','lsdAmount','roomStandardCharges','es_qty','extra_services','coupon_code_name','applied_discount_amount','discount_amount','max_discount_amount','discount_type','couponAppliedH','es_charges','extra_services','es_qty','standard_price_peakseason','standard_price_weekend','standard_price_weekday','no_of_week_days','no_of_weekend_days','no_of_peakseason_days','child_ages','h','r']);
                $nextpageurl = route('my-bookings');
                $data = [
                    'status' => 1,
                    'message'=>'',
                    'nextpageurl'=>$nextpageurl
                ];  
                return response()->json($data);  
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'Something went wrong'
                ];
                return response()->json($data);
            }
            
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'Something went wrong'
            ];
            return response()->json($data);
        }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $dayofweek = (isset($request->checkin_dates))?
            Carbon::createFromFormat('Y-m-d', $request->checkin_dates)->format('w'):
            Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->format('w');
        $startdate = Carbon::createFromFormat('Y-m-d', $request->checkin_dates);
        $enddate = Carbon::createFromFormat('Y-m-d', $request->checkout_dates);
        $difference = $startdate->diff($enddate)->days;
        $hotelQuery = HotelInfo::with([
            'hasFeaturedImage',
            'hasFacilities' => function($query) use ($request) {
                if (isset($request->facilities) && count(explode(',', $request->facilities)) > 0) {
                    $query->whereIn('facilities_id', explode(',', $request->facilities));
                }
            },
            'hasFeatures' => function($query) use ($request) {
                if (isset($request->features) && count(explode(',', $request->features)) > 0) {
                    $query->whereIn('features_id', explode(',', $request->features));
                }
            },
            'hasActiveRooms' => function($query) use ($request, $dayofweek) {
               if (isset($request->adult)) {$query->where('maximum_occupancy_adult', '>=', $request->adult);}
                if ($request->child) {$query->where('maximum_occupancy_child', '>=', $request->child);}
                if ($dayofweek === 0 || $dayofweek === 6) {
                    if (isset($request->min_price)) {$query->whereBetween('standard_price_weekend', [$request->min_price, $request->max_price]);}
                    $query->orderBy('standard_price_weekend', 'ASC');
                } else {
                    if (isset($request->min_price)) {$query->whereBetween('standard_price_weekday', [$request->min_price, $request->max_price]);}
                    $query->orderBy('standard_price_weekday', 'ASC');
                }
            },
            'hasLongStayDiscount' => function($query) use ($difference) {
                $query->where('lsd_min_days', '<=', $difference)
                ->where('lsd_max_days', '>=', $difference);
            }
        ]);
        $data = $hotelQuery->where('slug', $id)->first();
        $response = json_encode((object)[
            'hotel'=>$data,
            'price' => getRoomPrice($dayofweek, $data->hasActiveRooms, $data->hasLongStayDiscount),
            'hotelImage' => $data->hasFeaturedImage != null ?
                asset('hotel_images/' . $data->hasFeaturedImage->image) :
                asset('assets/images/product/img1.png'),
            'feature_facility' => (object)[
                'feature' => (count($data->hasFeatures) > 0)?getFeaturename($data->hasFeatures[0]->features_id):'',
                'facility' =>  (count($data->hasFacilities) > 0)?getFacilityname($data->hasFacilities[0]->facilities_id):'',
                'feature_facility_total' => count($data->hasFeatures) - 1 + (count($data->hasFacilities) - 1)
            ],
            'redirect_url' => route('hotel-detail', [$data->slug]) . getQueryParams($request->all())
        ]);
        return response($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(Home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(Home $home)
    {
        //
    }

}
