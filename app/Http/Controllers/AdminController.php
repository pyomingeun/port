<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reward;
use App\Models\HotelInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\HotelEmailVerification;
use App\Models\Booking;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    // load view admin step of hotel setup
    public function customer_management(Request $request)
    {
        $query = User::where('user.status', '!=', 'deleted');
        // $query->where('user.status', '!=', 'deleted');
        $query->where('user.access', '=', 'customer');
        $query->select(['*']);
             
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->whereNested(function($query) use ($keyword) {
                $query->where('user.full_name', 'LIKE', "%{$keyword}%");
                $query->orWhere('user.email', 'LIKE', "%{$keyword}%");
            });
            // $query->where('user.full_name',  'like', '%' . $request->q . '%')->Orwhere('user.email',  'like', '%' . $request->q . '%');
        }
        
        if($request->status !='')
        {
            $query->where('status', '=', $request->status);
        }
        $query->get();

        // $lastquery = DB::getQueryLog();
        // $lastqueryres = end($lastquery);
        // dd($lastqueryres);

        $c = (isset($request->c) && $request->c !='')?$request->c:'id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        $dates = (isset($request->dates) && $request->dates !='')?$request->dates:'';
        $query->orderBy($c,$o);
        $users = $query->paginate(8);
        
        // return view('admin.customer_listing',compact('users'));
        return view('admin.customer_listing')->with(['users'=>$users,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'dates'=>$dates]);
    }


    // load view admin step of hotel setup
    public function hotel_managment(Request $request)
    {
        // dd($request->all());
        // DB::enableQueryLog();
        $query = HotelInfo::join('user', 'user.id', '=', 'hotel_info.hotel_id');
        $query->where('user.status', '!=', 'deleted');
        $query->where('user.access', '=', 'hotel_manager');
        $query->select(['user.status','user.access','user.email', 'hotel_info.*']);
        
        if(isset($request->q) && $request->q !='')
        {
            $keyword = $request->q;
            $query->whereNested(function($query) use ($keyword) {
                $query->where('hotel_info.hotel_name', 'LIKE', "%{$keyword}%");
                $query->orWhere('user.email', 'LIKE', "%{$keyword}%");
            });
            // $query = $query->where('hotel_info.hotel_name',  'like', '%' . $request->q . '%')->orWhere('user.email',  'like', '%' . $request->q . '%');
        }

        if(isset($request->status) && $request->status !='')
        {
            $query = $query->where('user.status', '=', $request->status);
        }

        if(isset($request->sd) && isset($request->ed) && $request->sd !='' && $request->ed !='')
        {
            $date1=date_create($request->sd);
            $start_date = date_format($date1,"Y-m-d");
            $query = $query->where('hotel_info.created_at', '>=', $start_date);

            $date2=date_create($request->ed);
            $end_date = date_format($date2,"Y-m-d");
            $query = $query->where('hotel_info.created_at', '<=', $end_date);
        }

        /* if($request->ed !='')
        {
            $date2=date_create($request->ed);
            $end_date = date_format($date2,"Y-m-d");
            $query = $query->where('hotel_info.created_at', '<=', $end_date);
        } */
        
        $query->get();

        // $lastquery = DB::getQueryLog();
        // $lastqueryres = end($lastquery);
        // dd($lastqueryres);

        /* if($request->dates !='')
        {

            // BookingDates::where('email', Input::get('email'))
            // ->orWhere('name', 'like', '%' . Input::get('name') . '%')->get();
    
            // dd($request->dates);
            $date_range = explode(" - ", $request->dates);
            $date=date_create($date_range[0]);
            $start_date = date_format($date,"Y-m-d");
            $date2=date_create($date_range[1]);
            $end_date = date_format($date2,"Y-m-d");
            $query = $query->where('hotel_info.created_at', '>=', $start_date)->where('hotel_info.created_at', '<=', $end_date);
            // dd($request->dates,$date_range,$start_date,$end_date);
        }*/

        // $query->orderBy('hotel_info.id','desc');
        $c = (isset($request->c) && $request->c !='')?$request->c:'id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        $sd = (isset($request->sd) && $request->sd !='')?$request->sd:'';
        $ed = (isset($request->ed) && $request->ed !='')?$request->ed:'';
        $query->orderBy($c,$o);
        
        $hotels = $query->paginate(8);
        // echo "<pre>";
        // dd($hotels); die;
        // return view('admin.hotel_managment_listing',compact('hotels'));
        // $data = ['hotels'=>$hotels,'o'=>$o,'c'=>$c,'q'=>$q,'status'=>$status,'dates'=>$dates];
        // dd($data);
        return view('admin.hotel_managment_listing')->with(['hotels'=>$hotels,'o'=>$o,'c'=>$c,'q'=>$q,'status'=>$status,'sd'=>$sd,'ed'=>$ed]);
    }

    // load view admin step of hotel setup
    public function hotel_setup()
    {
        return view('admin.hotel_managment_admint_step');
    }

    // hotel setup submit 
    public function hotel_setup_submit(Request $request)
    {
        $access = auth()->user()->access;
        $randomId  = rand(1000,9999);
        $randomSlugId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $activation_code = $timestamp."".$randomId;
        $slug = $timestamp."".$randomSlugId;
        
        $newuser= User::create([
            'full_name' => $request->hotel_name,
            'email' => strtolower($request->hotel_email), //$request->email,
            'phone' => '',
            'set_password_code' => $activation_code,
            'password' => Hash::make($randomId),
            'access'=>'hotel_manager',
            'status'=>'inactive'
        ]);
        
        if($newuser)
        {
            $hotel_info = HotelInfo::create([
                'hotel_name' => $request->hotel_name,
                'hotel_id' => $newuser->id,
                'slug' => $slug
            ]);
            if($hotel_info)
            {
                $url = route('set_your_password', ['token' => $activation_code]);
                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else
                    $nextpageurl = route('hm_basic_info', ['id' => $newuser->id]);
               // $request->session()->put('unverified_email', $request->email);
        
                    $data = [
                        'name' => $request->hotel_name,
                         'url' => $url,
                        'nextpageurl'=>$nextpageurl
                    ];
                    // env('MAIL_FROM_ADDRESS')
                Mail::to($request->hotel_email)->send(new HotelEmailVerification($data));
                return response()->json($data);

            }
        }

    }

    public function resendSetPasswordLink($id)
    {
        $access = auth()->user()->access;
        $randomId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $activation_code = $timestamp."".$randomId;
        $user = User::where('user.status', '!=', 'deleted')->where('user.id', '=', $id);

        if($user)
        {
            $url = route('set_your_password', ['token' => $activation_code]);
            $nextpageurl = route('hm_basic_info', ['id' => $newuser->id]);
            $data = [
                'name' => $request->hotel_name,
                'url' => $url,
                'nextpageurl'=>$nextpageurl
            ];
            Mail::to($request->hotel_email)->send(new HotelEmailVerification($data));
            return response()->json($data);
        }
    }

    public function staff_management($id,Request $request)
    {
        // $query = User::where('user.status', '!=', 'deleted');
        // $query->where('user.access', '=', 'hotel_staff');
        // $query->select(['user.*']);

        // $query = HotelInfo::join('user', 'user.id', '=', 'hotel_info.hotel_id');
        // $query->where('user.status', '!=', 'deleted');
        // $query->where('user.access', '=', 'hotel_manager');
        // $query->select(['user.status','user.access','user.email', 'hotel_info.*']);
        // $query->orderBy('hotel_info.hotel_name','asc');
        // $hotels = $query->get();
        
        $query = User::join('hotel_info', 'user.hotel_id', '=', 'hotel_info.hotel_id');
        $query->where('user.status', '!=', 'deleted');
        $query->where('user.access', '=', 'hotel_staff');
        $query->select(['hotel_info.hotel_name','user.*' ]);
        $query->get();

        if($id !=0 && $id !='all')
        {
            $query->where('user.hotel_id', '=', $id);
        }    
        
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->whereNested(function($query) use ($keyword) {
                $query->where('user.full_name', 'LIKE', "%{$keyword}%");
                $query->orWhere('user.email', 'LIKE', "%{$keyword}%");
                $query->orWhere('hotel_info.hotel_name', 'LIKE', "%{$keyword}%");
            });
            //  $query->where('user.full_name',  'like', '%' . $request->q . '%')->orWhere('user.email',  'like', '%' . $request->q . '%');
        }
        
        if($request->status !='')
        {
            $query->where('user.status', '=', $request->status);
        }

        $query->get();

         

        $c = (isset($request->c) && $request->c !='')?$request->c:'id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        $dates = (isset($request->dates) && $request->dates !='')?$request->dates:'';
        $query->orderBy($c,$o);

        $hotel_staff = $query->paginate(8);

        $hotel = HotelInfo::where('hotel_id', '=', $id)->select('*')->first();
        // echo "<pre>";
        // dd($hotel->hotel_name); die;
        // return view('admin.hotel_staff_listing',compact('hotel'),compact('hotel_staff')); 
        return view('admin.hotel_staff_listing')->with(['hotel'=>$hotel,'hotel_staff'=>$hotel_staff,'o'=>$request->o,'c'=>$request->c,'id'=>$id,'q'=>$q,'status'=>$status,'dates'=>$dates]);   
    }


        // load view hotel staff add/edit
    public function hotel_staff_input($id=0)
    {
        $query = HotelInfo::join('user', 'user.id', '=', 'hotel_info.hotel_id');
        $query->where('user.status', '!=', 'deleted');
        $query->where('user.access', '=', 'hotel_manager');
        $query->select(['user.status','user.access','user.email', 'hotel_info.*']);
        $query->orderBy('hotel_info.hotel_name','asc');
        $hotels = $query->get(); 
        if($id == 0) 
            return view('admin.hotel_staff_input',compact('hotels'));
        else
        {
            // dd($hotels);
            $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            $hotelinfo = HotelInfo::where('hotel_id', '=', $user->hotel_id)->first();
            // dd($hotelinfo);
            // dd($hotelinfo->hotel_name);
            //return view('admin.hotel_staff_input',compact('user'),compact('hotels'),compact('hotelinfo'));
            return view('admin.hotel_staff_input')->with(['user'=>$user,'hotels'=>$hotels,'hotelinfo'=>$hotelinfo]);
        }
    }

    // hotel setup submit 
    public function staff_input_submit(Request $request)
    {
        $access = auth()->user()->access;
        $randomId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $activation_code = $timestamp."".$randomId;

        if($request->id == 0)
        {
            $newuser= User::create([
                'full_name' => $request->full_name,
                'email' => strtolower($request->email), //$request->email,
                'phone' => '',
                'set_password_code' => $activation_code,
                'password' => Hash::make($randomId),
                'access'=>'hotel_staff',
                'hotel_id'=>$request->hotel,
                'status'=>'inactive'
            ]);
            
            if($newuser)
            {
                $url = route('set_your_password', ['token' => $activation_code]); 
                $nextpageurl = route('staff_management', ['id' => $request->hotel ]);
        
                $data = [
                    'name' => $request->full_name,
                    'url' => $url,
                    'nextpageurl'=>$nextpageurl
                ];

                Mail::to($request->email)->send(new HotelEmailVerification($data));
                return response()->json($data);
            }
        
        }
        else
        {
            $user = User::where('id', '=', $request->id)->where('status', '!=', 'deleted')->first();

            if($user)
            {
                $user->full_name = $request->full_name;
                $user->hotel_id = $request->hotel;
                $user->save();

                $nextpageurl = route('staff_management', ['id' => $request->hotel ]);
                $data = [
                    'name' => $request->full_name,
                    'url'=>'',
                    'nextpageurl'=>$nextpageurl
                ];

                return response()->json($data);
                
            }

        }
    }
    
    // manage customer statuc action active/inactive/delete
    public function customer_status($id,$status)
    {
        // dd($id,$status);    
        $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->first();

        if($user)
        {
            if($status =='deleted')
            {
                $query = Booking::where('customer_id', '=', $user->id);
                $query->whereNested(function($query) {
                    $query->where('booking_status', '=', "on_hold");
                    $query->orWhere('booking_status', '=', "confirmed");
                });
                $query->where('status', '!=', 'deleted');
                $noOfBookings = $query->count();
                if($noOfBookings)
                {
                    return redirect()->route('customer_management')->with('error_msg',"This customer can not be delete because he/she has ".$noOfBookings." on-hold/confirmed booking(s)");
                }
                else
                {
                    $user->status = $status;
                    $user->save();
                    return redirect()->route('customer_management')->with('success_msg','Customer '.$status.' successfully');
                }
            }
            elseif($status =='active' || $status =='inactive')
            {
                $status = ($status =='active')?'inactive':'active'; 
                $user->status = $status;
                $user->save();
                return redirect()->route('customer_management')->with('success_msg','Customer '.$status.' successfully');
            }
            else
            {
                return redirect()->route('customer_management')->with('error_msg','Invalid status');
            }
        }
        else
            return redirect()->route('customer_management')->with('error_msg','Invalid user');

    }
    // close customer status 
    
    // manage hotel-staff status action active/inactive/delete
    public function staff_status($id,$status)
    {
        //  dd($id,$status);    
        $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->first();

        if($user)
        {
            if($status =='deleted')
            {
                $user->status = $status;
                $user->save();
                return redirect()->route('staff_management','all')->with('success_msg','Hotel-Staff '.$status.' successfully');
            }
            elseif($status =='active' || $status =='inactive')
            {
                $status = ($status =='active')?'inactive':'active'; 
                $user->status = $status;
                $user->save();
                return redirect()->route('staff_management','all')->with('success_msg','Hotel-Staff '.$status.' successfully');
            }
            else
            {
                return redirect()->route('staff_management','all')->with('error_msg','Invalid status');
            }
        }
        else
            return redirect()->route('staff_management','all')->with('error_msg','Invalid user');

    }
    // close customer status

        
    // manage hotel-manager status action active/inactive/delete
    public function manager_status($id,$status)
    {
        // dd($id,$status);    
        $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->first();

        if($user)
        {
            if($status =='deleted')
            {
                $query = Booking::where('hotel_id ', '=', $user->id);
                $query->whereNested(function($query) {
                    $query->where('booking_status', '=', "on_hold");
                    $query->orWhere('booking_status', '=', "confirmed");
                });
                $query->where('status', '!=', 'deleted');
                $noOfBookings = $query->count();
                if($noOfBookings)
                {
                    return redirect()->route('hotel_managment')->with('error_msg',"This hotel-manager can not be delete because he/she has ".$noOfBookings." on-hold/confirmed booking(s)");
                }
                else
                {
                    $user->status = $status;
                    $user->save();
                    $whereHotel =array('hotel_id'=>$user->id);
                    $hotel = HotelInfo::where($whereHotel)->first();
                    if($hotel)
                    {
                        $hotel->status = $status;
                        $hotel->save();
                    }
                    return redirect()->route('hotel_managment')->with('success_msg','Hotel-Manager '.$status.' successfully');
                }

            }
            elseif($status =='active' || $status =='inactive')
            {
                $status = ($status =='active')?'inactive':'active'; 
                $user->status = $status;
                $user->save();
                $whereHotel =array('hotel_id'=>$user->id);
                $hotel = HotelInfo::where($whereHotel)->first();
                if($hotel)
                {
                    $hotel->status = $status;
                    $hotel->save();
                }
                return redirect()->route('hotel_managment')->with('success_msg','Hotel-Manager '.$status.' successfully');
            }
            else
            {
                return redirect()->route('hotel_managment')->with('error_msg','Invalid status');
            }
        }
        else
            return redirect()->route('hotel_managment')->with('error_msg','Invalid Manager');

    }
    // close customer status
    
    
    // load view customer add/edit
    public function customer_input($id=0)
    {
        if($id == 0) 
            return view('admin.customer_input');
        else
        {
            $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            return view('admin.customer_input')->with(['user'=>$user]);
        }
    }
    // close 

     // customer submit 
    public function customer_input_submit(Request $request)
    {
        $access = auth()->user()->access;
        $randomId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $activation_code = $timestamp."".$randomId;

        if($request->id == 0)
        {
            $newuser= User::create([
                'full_name' => $request->full_name,
                'email' => strtolower($request->email), //$request->email,
                'phone' => $request->phone,
                'set_password_code' => $activation_code,
                'password' => Hash::make($randomId),
                'access'=>'customer'
            ]);
            
            if($newuser)
            {
                $url = route('set_your_password', ['token' => $activation_code]); 
                $nextpageurl = route('staff_management', ['id' => $request->hotel ]);
        
                $data = [
                    'name' => $request->full_name,
                    'url' => $url,
                    'nextpageurl'=>$nextpageurl
                ];

                // Mail::to($request->email)->send(new HotelEmailVerification($data));
                return response()->json($data);
            }
        
        }
        else
        {
            $user = User::where('id', '=', $request->id)->where('status', '!=', 'deleted')->first();

            if($user)
            {
                $user->full_name = $request->full_name;
                $user->phone = $request->phone;
                $user->save();

                $nextpageurl = route('customer_management');
                $data = [
                    'name' => $request->full_name,
                    'url'=>'',
                    'nextpageurl'=>$nextpageurl
                ];

                return response()->json($data);
                
            }

        }
    }
    
    // view customer reward-history 
    public function rewardDetails($id)
    {
        $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->select('id','full_name','total_rewards_points')->first();
        $query = Reward::where('status', '=', 'active')->where('user_id', '=', $id);
        $query->select(['*']);
        
        $query->orderBy('reward_history.id','desc');
        // dd($query);
        $rewards =   $query->get();
        
        // updateRewards(10,28,'credited','New Booking','You got this reward points for booking');
        return view('admin.reward_details')->with(['id'=>$id,'user'=>$user,'rewards'=>$rewards]);   
    }

    // reward points update by admin 
    public function rewardCreditDebit(Request $request)
    {
        $access = auth()->user()->access;
        $randomId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $slug = $timestamp."".$randomId;
        $id = $request->id; 
        $user = User::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
        if($user)
        {
            if($request->reward_points > 0)
            {
                $creditedPoints = Reward::where('user_id','=',$id)->where('reward_type','=','credited')->where('status','=','active')->sum('reward_points');
                $debitedPoints = Reward::where('user_id','=',$id)->where('reward_type','=','debited')->where('status','=','active')->sum('reward_points');
                
                $title = '';
                $message = '';
                $remaing_points = $creditedPoints-$debitedPoints;
                if($request->rtype == 'debited')
                {
                    $title = isset($request->title)?$request->title:'Admin Charged';
                    $message = isset($request->message)?$request->message:'admin charge you penalty.';
                    $remaing_points = $remaing_points - $request->reward_points;
                }
                else if($request->rtype == 'credited')
                {
                    $title = isset($request->title)?$request->title:'Admin Gift';
                    $message = isset($request->message)?$request->message:'admin gift you reword points.';
                    $remaing_points = $remaing_points + $request->reward_points;
                }
                
                $transaction_on = date_format(Carbon::now(),"Y-m-d");
    
                $newReward= Reward::create([
                    'slug' => $slug,
                    'user_id' => $id,
                    'booking_slug'=>'',
                    'title'=>$title,
                    'message'=>$message,
                    'reward_points'=>$request->reward_points,
                    'remaing_points'=>$remaing_points,
                    'reward_type'=>$request->rtype,
                    'transaction_on'=>$transaction_on,
                    'status'=>'active',
                    'created_by'=>auth()->user()->id,
                    'updated_by'=>auth()->user()->id,
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
                    'message' =>'Reward points should be greater than 1.'
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

    // manage editor's pick status action yes/no
    public function isEitdorPicks($id,$status)
    {
        $hotel = HotelInfo::where('hotel_id', '=', $id)->where('status', '!=', 'deleted')->first();

        if($hotel)
        {
            if($status =='yes' || $status =='no')
            {
                $status = ($status =='yes')?'no':'yes'; 
                $hotel->editors_pick = $status;
                $hotel->save();
                return redirect()->route('hotel_managment')->with('success_msg',"Editors Pick ".$status." successfully");
            }
            else
            {
                return redirect()->route('hotel_managment')->with('error_msg','Invalid status');
            }
        }
        else
            return redirect()->route('hotel_managment')->with('error_msg','Invalid Hotel');
    }
    
}
