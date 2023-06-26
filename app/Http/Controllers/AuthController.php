<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Unregistered;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
// use Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerfication;
use App\Mail\ForgotMail;
use App\Mail\CustomerWelcomeEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\HotelInfo;
// use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
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

    // Customer sign up form 
    public function signup()
    {
        // Artisan::call('cache:clear');
        return view('frontend.customer_signup');

        // $user = User::find($id)
        // $user = User::where('status', 'active')->first();
        // $user = User::where([
        //     'status' => 'active',
        //     'age' => '15'
        // ])->first();
    }

    public function signupSubmit(Request $request)
    {
        // echo 'kkk is workded';
        // print_r($request->all());
        
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email', // |unique:user
            'password' => 'required|min:8',
        ]);
        
        $randomId  = rand(1000,9999);
        $timestamp = Carbon::now()->timestamp;
        $activation_code = $timestamp."".$randomId;

        $newuser= Unregistered::create([
            'full_name' => $request->full_name,
            'email' => strtolower($request->email), //$request->email,
            'phone' => $request->phone,
            'activation_code' => $activation_code,
            'password' => Hash::make($request->password)
        ]);
        

        $url = route('emailVerfication', ['id' => $activation_code]);
        $nextpageurl = route('emailsent', ['id' => $newuser->id]);
       // $request->session()->put('unverified_email', $request->email);

            $data = [
                'name' => $request->full_name,
                 'url' => $url,
                'nextpageurl'=>$nextpageurl
            ];
                // env('MAIL_FROM_ADDRESS')
         Mail::to($request->email)->send(new EmailVerfication($data));
       

        return response()->json($data);
       // return Redirect::route('emailsent')->with( ['data' => $request->all()] );
        
        // return redirect()->route('emailsent')
        //                 ->with('success','User created successfully.'); 
    }

    
    // Customer sign up form 
    public function emailsent($id) // Request $request
    {
        //$email = $request->session()->get('unverified_email');
       // $request->session()->forget('unverified_email');
        
       $user = Unregistered::where('id', $id)->first();
       if($user)
       {
          return view('frontend.verification_email_sent', ['email' => $user->email]);
       }
       else
       {  return redirect()->route(''); }
        //  return view('greeting', ['name' => 'James']);
    }

    public function emailVerfication($code)
    {
        $user = Unregistered::where('activation_code', $code)->first();
        if($user)
        {
            $isuser = User::where('email', strtolower($user->email))->where('status', '!=', 'deleted')->first();
            if($isuser)
            {
                $data = [
                    'status' => 0,
                    'message'=>'Email aleardy exist.'
                ];
            }
            else
            {
                $newuser= User::create([
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'password' => $user->password
                ]); 
                $subsribeRes = subsribeUs($user->email,$newuser->id);
                $user->delete(); 
                
                $url = route('home');
                $nextpageurl = route('home');
                $data = [
                    'status' => 1,
                    'message'=>'Welcome Email',
                    'name' => $user->first_name,
                    'url' => $url,
                    'nextpageurl' => $nextpageurl
                ];
               //  Mail::to($user->email)->send(new CustomerWelcomeEmail($data));                
            }
           
        }
        return redirect()->route('user_reg_succes');
       //  return view('frontend.email_verify_success');
    }

    public function user_reg_succes()
    {
        // echo auth()->user()->access; 
        return view('frontend.email_verify_success');
    }

    public function reg_emailcheck(Request $request)
    {

        // $credentials =array('email'=>strtolower($request->email),'status'=>'active');
        // $user = User::where($credentials)->first();
        // $user = User::where('email', strtolower($request->email))->first();
        $user = User::where('email', strtolower($request->email))->where('status', '!=', 'deleted')->first();

        if($user)
        {
            $data = [
                'status' => 0,
                'message'=>'This email is already register with us.'
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 1,
                'message'=>''
            ];
            return response()->json($data);
        }


        
        // $identity = $this->common->getWhereRowSelect('user',array('LOWER(email)'=> strtolower($_REQUEST['email'])),'id');
        //~ lastquery(1);
        // echo 'false'; // (empty($identity))?'true':'false';  
    }

    
    public function login(Request $request)
    {   
        /* 
        $request->validate([
            'loginemail' => 'required',
            'loginpassword' => 'required'
        ]); */ 
        // dd($request);
        if($request->loginemail !='' && $request->loginpassword !='')
        {
            $credentials =array('email'=>$request->loginemail,'password'=>$request->loginpassword,'status'=>'active');

            if (Auth::attempt($credentials)) {

                $usercredentials =array('email'=>auth()->user()->email);
                $user = User::where($usercredentials)->first();
                if($user)
                {
                    // $user->is_loging = 1;
                    // $user->last_activity_at = Carbon::now();
                    // $user->save();
                    $nexturl = $request->nexturl; // (isset($request->nexturl) && $request->nexturl !='' )?$request->nexturl:'';
                    
                    if(auth()->user()->access=='hotel_manager')
                    {
                        $hotel = HotelInfo::where('hotel_id', '=', $user->id)->first();
                        if(isset($hotel->completed_percentage) && (int)$hotel->completed_percentage <= 99 )
                        {   
                            $loingedId = $user->id; // base64_encode($user->id); // decrypt($user->id);
                            $nextpageurl = route('hm_basic_info', ['id' => $loingedId]);  
                        }else 
                            $nextpageurl = route('dashboard');
                    } 
                    else if(auth()->user()->access=='hotel_staff')
                        $nextpageurl = route('bookings');
                    else if(auth()->user()->access=='admin')
                        $nextpageurl = route('dashboard');        
                    else if($nexturl !='')
                        $nextpageurl = $nexturl;   
                    else
                        $nextpageurl = route('home'); 
                    // echo $nextpageurl." == ". $nexturl;   die;   
                    // dd($request);
                    $data = [
                        'message' => "Login Successfully",
                        // 'auth' => auth()->user(),
                        'nextpageurl'=>$nextpageurl
                    ];
                    return response()->json($data);
                }
            }
            else{
                $data = [
                    'message' => "Your email or password is invalid.",
                    'nextpageurl'=>""
                ];
                return response()->json($data);
            }
        }
        else{
                $data = [
                    'message' => "Email & password both are required.",
                    'nextpageurl'=>""
                ];
                return response()->json($data);
        }

        

        // return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');

           /* $request->validate([
               'login_email' => 'required',
               'login_password' => 'required'
           ]);
           $user = User::where('email', $request->login_email)->first();
           if ($user) {
               if (Hash::check($request->login_password, $user->password)) {
                   Auth::login($user);
                   if (isset($request->returnUrl)) {
                       return redirect($request->returnUrl);
                   }
                   return redirect()->route('customer-dashboard')->with('success', 'You are now logged in.');
               } else {
                   return redirect()->back()->with('error', 'Invalid login credentials.');
               }
           } else {
               return redirect()->back()->with('error', 'User not found');
           }*/
    }
   
    public function forgot_password(Request $request)
    {
        $request->validate([
            'forgot_email' => 'required|email'
        ]);
        $user = User::where('email', $request->forgot_email)->where('status','=','active')->first();
        if ($user) {
            $user->forgot_password_code = Str::random(12);
            $user->save();
            $url = route('reset_password', ['token' => $user->forgot_password_code]);
            $nextpageurl = route('forgot_email_sent', ['id' => $user->id]);
            $data = [
                'status' => 1,
                'message'=>'Email resent successfully.',
                'name' => $user->first_name,
                'url' => $url,
                'nextpageurl' => $nextpageurl
            ];
            Mail::to($user->email)->send(new ForgotMail($data));
            return response()->json($data);
           // return response()->json(['status' => 1, 'message' => 'Reset password link sent to your email.']);
        } else {
            // return response()->json(['status' => 0, 'message' => 'This email is not register with us.']);
            $data = [
                'status' => 0,
                'message' => "This email is not register with us.",
                'nextpageurl'=>""
            ];
            return response()->json($data);
        }
    }
   
    public function forgot_email_sent($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return view('frontend.forgot_email_sent', compact('user'));
        } else {
            return redirect()->route('home'); // redirect()->route('home')->with('error', 'Invalid token');
        }
    }

    public function reset_password($token)
    {
        $user = User::where('forgot_password_code', $token)->first();
        if ($user) {
        //   echo "<pre>";  print_r($user); die;
            return view('frontend.reset_password', compact('user'));
        } else {
            // return view('frontend.reset_password');
            return redirect()->route('home');
        }
    }
   
    public function update_password(Request $request)
    {
        $request->validate([
            'reset_new_password' => 'required|min:8',
            'reset_confirm_password' => 'required|same:reset_new_password'
        ]);
        $user = User::where('forgot_password_code', $request->code)->first();
        if ($user) {
            if(Hash::check($request->reset_new_password, $user->password))
            {
                $data = [
                    'status' => 0,
                    'message'=>'New password should be diffrent from old password.'
                ];
                return response()->json($data);                
            }
            else
            {
                $user->password = Hash::make($request->reset_new_password);
                $user->forgot_password_code = '';
                $user->save();
    
                $nextpageurl = route('forgot_password_success');
                $data = [
                    'status' => 1,
                    'name' => $user->first_name,
                    'nextpageurl' => $nextpageurl
                ];
                return response()->json($data);    
            }

        } else {
            $data = [
                'status' => 0,
                'message' => "This link is expired",
                'nextpageurl'=>""
            ];
            return response()->json($data);
        }
    }

    public function set_your_password($token)
    {
        $user = User::where('set_password_code', $token)->first();
        if ($user) {
        //   echo "<pre>";  print_r($user); die;
            return view('frontend.set_password_hotel', compact('user'));
        } else {
            // return view('frontend.reset_password');
            return redirect()->route('home');
        }
    }

    public function set_password(Request $request)
    {
        $user = User::where('set_password_code', $request->code)->first();
        if ($user) {
            $user->password = Hash::make($request->set_new_password);
            $user->set_password_code = '';
            $user->status = 'active';
            $user->save();

            $whereHotel =array('hotel_id'=>$user->id);
            $hotel = HotelInfo::where($whereHotel)->first();
            if($hotel)
            {
                $hotel->status = 'active';
                $hotel->save();
            } 
            
            $nextpageurl = route('set_password_success');
            $data = [
                'status' => 1,
                'name' => $user->first_name,
                'nextpageurl' => $nextpageurl
            ];
            
            /*
            $url = route('home');
            $nextpageurl = route('home');
            $data2 = [
                'status' => 1,
                'message'=>'Welcome Email',
                'name' => $user->first_name,
                'url' => $url,
                'nextpageurl' => $nextpageurl
            ];
            Mail::to($user->email)->send(new HotelWelcomeEmail($data2));
            */
            return response()->json($data);

        } else {
            $data = [
                'status' => 0,
                'message' => "This link is expired",
                'nextpageurl'=>""
            ];
            return response()->json($data);
        }
    }

    public function forgot_password_success()
    {
        return view('frontend.forgot_password_success');
    }

    public function set_password_success()
    {
        return view('frontend.set_password_success');
    }    

    public function change_password(Request $request)
    {
        // DB::enableQueryLog();

        // $query = DB::getQueryLog();
        // print_r($user);
        // dd($query);

        // if(!Hash::check($request->old_password, auth()->user()->password)){
        //     return back()->with("error", "Old Password Doesn't match!");
        // }
       

        if(Hash::check($request->old_password, auth()->user()->password))
        {
            if($request->old_password != $request->new_change_password)
            {
                $credentials =array('email'=>auth()->user()->email,'status'=>'active');
                $user = User::where($credentials)->first();
                if($user)
                {
                    $user->password = Hash::make($request->new_change_password);
                    $user->save();
                    // $nextpageurl = route('forgot_password_success');
                    $data = [
                        'status' => 1,
                        // 'nextpageurl' => $nextpageurl,
                        'message' => 'Password changed successfully.'
                    ];
                    return response()->json($data); 
                }
                else
                {
                    $data = [
                        'status' => 0,
                        'message'=>'passord not chagned please try with re-login.'
                    ];
                    return response()->json($data);
                }

            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'Old password & New password should be diffrent.'
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'Old password is incorrect.'
            ];
            return response()->json($data);
        }
    }



    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('home');
    }



    public function oldPwdcheck(Request $request)
    {
        // echo auth()->user()->email; 
        $credentials =array('email'=>auth()->user()->email,'password'=>Hash::make($request->old_password),'status'=>'active');

        $user = User::where($credentials)->first();
        if($user)
        {
            $data = [
                'status' => 1,
                'message'=>''
            ];
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'Old password is incorrect.'
            ];
            return response()->json($data);
        }
    }


    /* public function changeemailsent($id) // Request $request
    {
        //$email = $request->session()->get('unverified_email');
       // $request->session()->forget('unverified_email');
        
       $user = Unregistered::where('id', $id)->first();
       if($user)
       {
          return view('frontend.verification_email_sent', ['email' => $user->email]);
       }
       else
       {  return redirect()->route('home'); }
        //  return view('greeting', ['name' => 'James']);
    }*/ 

    public function changeEmailVerfied($code)
    {
        $user = User::where('change_email_verification_code', $code)->first();
        if($user)
        {
            $newemail = $user->new_email_for_change; 
            $user->email = $newemail;
            $user->new_email_for_change = '';
            $user->change_email_verification_code = '';
            $user->save();  
            return redirect()->route('email_changed_succes');
        }
        return redirect()->route('home');
       //  return view('frontend.email_verify_success');
    }
    
    public function email_changed_succes()
    {
        return view('frontend.email_changed_success');
    }

    // resend signup verification
    public function resend_signup_link(Request $request)
    {
        $user = Unregistered::where('email', $request->email)->first();
        if ($user) {
            $user->activation_code = Str::random(12);
            $user->save();
            $url = route('emailVerfication', ['id' =>  $user->activation_code]);
            $nextpageurl = route('emailsent', ['id' => $user->id]);
           // $request->session()->put('unverified_email', $request->email);
    
                $data = [
                    'status' => 1,
                    'message'=>'Email resent successfully.',
                    'name' => $user->full_name,
                     'url' => $url,
                    'nextpageurl'=>$nextpageurl
                ];
                    // env('MAIL_FROM_ADDRESS')
             Mail::to($request->email)->send(new EmailVerfication($data));
             return response()->json($data);
 
        } else {
            $data = [
                'status' => 0,
                'message' => "Something went wrong plese try agian with refresh.",
                'nextpageurl'=>""
            ];
            return response()->json($data);
        }
    }

    // resend reset password link verification
    public function resend_resetpass_link(Request $request)
    {

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
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function show(Auth $auth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function edit(Auth $auth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auth $auth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auth  $auth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auth $auth)
    {
        //
    }


    public function kakao()
    {
        # code...
    }

    public function naver()
    {
        # code...
    }
}
