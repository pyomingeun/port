<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangeEmailVerification;
use App\Models\Booking;

class CustomerController extends Controller
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

    // customer profile 
    public function my_profile()
    {
        $credentials =array('email'=>auth()->user()->email,'status'=>'active');
        $user = User::where($credentials)->first();
        if($user)
        {
            return view('customer.my_profile', compact('user'));
        } 
        else
            return redirect()->route('home');   
    }


    public function deleteMyAcccount()
    {
        $credentials =array('email'=>auth()->user()->email);
        $user = User::where($credentials)->first();
        if($user)
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
                return redirect()->route('my_profile')->with('error_msg',"You can not delete your account because you have ".$noOfBookings." on-hold/confirmed booking(s)");
            }
            else
            {
                $user->status = 'deleted';
                $user->save();
                Session::flush();
                Auth::logout();
                return redirect()->route('home')->with('success_msg','Your account   successfully deleted');
            }
        }                          
    }

    public function email_change_req(Request $request)
    {
        $credentials =array('email'=>auth()->user()->email);
        $user = User::where($credentials)->first();
        if($user)
        {
            $randomId  = rand(1000,9999);
            $timestamp = Carbon::now()->timestamp;
            $activation_code = $timestamp."".$randomId;

            $user->new_email_for_change = $request->email;
            $user->change_email_verification_code = $activation_code;
            $user->save();

            $url = route('changeEmailVerfied', ['token' => $activation_code]);
            $nextpageurl = '';//route('changeemailsent', ['id' => $user->id]);
           // $request->session()->put('unverified_email', $request->email);
    
                $data = [
                    'name' => $request->full_name,
                     'url' => $url,
                    'nextpageurl'=>$nextpageurl
                ];
                    // env('MAIL_FROM_ADDRESS')
            Mail::to($request->email)->send(new ChangeEmailVerification($data));
            return response()->json($data);
        }                          
    }

    public function customer_profile_update(Request $request)
    {		
           $credentials =array('id'=>$request->t,'email'=>$request->e,'status'=>'active');//  ,$request->field=>$request->val
            $user = User::where($credentials)->first();

            if($user)
            {
                // echo $request->field." field<br>";
                // echo $request->val." val";
                // die;
                if($request->field =='full_name')
                     $user->full_name = $request->val;
                else if($request->field =='email')
                     $user->email = $request->val;
                else if($request->field =='phone')
                     $user->phone = $request->val;
                $user->save();
                // $nextpageurl = route('forgot_password_success');
                $fieldName = ucwords(str_replace("_"," ",$request->field));
 
                $data = [
                    'status' => 1,
                    // 'nextpageurl' => $nextpageurl,
                    'message' => $fieldName.' changed successfully.'
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'somthing went wrong please try with re-login.'
                ];
                return response()->json($data);
            }
    }



    public function uploadProfilePic(Request $request)
    {
        $whereUser =array('id'=>auth()->user()->id,'status'=>'active');
        $user = User::where($whereUser)->first();
        if($user)
        {
            // $folderPath = public_path('profile_pic/');
            $folderPath = 'profile_pic/';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $profile_pic = uniqid() . '.png';
            $file = $folderPath . $profile_pic;
    
            file_put_contents($file, $image_base64);
            $user->profile_pic = $profile_pic;
            $user->save();
            return response()->json(['status'=>1,'message'=>'Profile-picture updated successfully','pic'=>$profile_pic]);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }

    }

    public function deleteMyProfilePic()
    {
        $credentials =array('email'=>auth()->user()->email);
        $user = User::where($credentials)->first();
        if($user)
        {
            $user->profile_pic = '';
            $user->save();
            return response()->json(['status'=>1,'message'=>'Deleted successfully']);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }                          
    }
    
}
