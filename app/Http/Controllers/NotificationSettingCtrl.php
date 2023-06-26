<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class NotificationSettingCtrl extends Controller
{

    public function index()
    {
        $whereSetting =array('user_id'=>auth()->user()->id);
        $setting = NotificationSetting::where($whereSetting)->first(); 
        return view('notification.notification_setting')->with(['setting'=>$setting]);
    }

    public function update(Request $request)
    {
        $whereSetting =array('user_id'=>auth()->user()->id);
        $setting = NotificationSetting::where($whereSetting)->first(); 
        if($setting)
        {
            $setting->booking_on_hold_email = (isset($request->on_hold_email))?$request->on_hold_email:0;
            $setting->booking_confirmed_email = (isset($request->confirmed_email))?$request->confirmed_email:0;
            $setting->booking_completed_email = (isset($request->completed_email))?$request->completed_email:0;
            $setting->booking_cancelled_email = (isset($request->cancelled_email))?$request->cancelled_email:0;
            $setting->booking_refund_email = (isset($request->refund_email))?$request->refund_email:0;

            $setting->booking_on_hold_sms = (isset($request->on_hold_sms))?$request->on_hold_sms:0;
            $setting->booking_confirmed_sms = (isset($request->confirmed_sms))?$request->confirmed_sms:0;
            $setting->booking_completed_sms = (isset($request->completed_sms))?$request->completed_sms:0;
            $setting->booking_cancelled_sms = (isset($request->cancelled_sms))?$request->cancelled_sms:0;
            $setting->booking_refund_sms = (isset($request->refund_sms))?$request->refund_sms:0;

            $setting->status = 'active';
            $setting->updated_by = auth()->user()->id;
            $setting->updated_at = Carbon::now();
            $setting->save();  
            // return redirect()->route('notification-setting')->with('success', 'Saved successfully');

            $data = [
                'message' => "Saved successfully",
                'status'=>1
            ];
            return response()->json($data);
        }
        else
        {
            $newSetting= NotificationSetting::create([
                'booking_on_hold_email' => (isset($request->on_hold_email))?$request->on_hold_email:0,
                'booking_confirmed_email' => (isset($request->confirmed_email))?$request->confirmed_email:0,
                'booking_completed_email' => (isset($request->completed_email))?$request->completed_email:0,
                'booking_cancelled_email' => (isset($request->cancelled_email))?$request->cancelled_email:0,
                'booking_refund_email' => (isset($request->refund_email))?$request->refund_email:0,
                'booking_on_hold_sms' => (isset($request->on_hold_sms))?$request->on_hold_sms:0,
                'booking_confirmed_sms' => (isset($request->confirmed_sms))?$request->confirmed_sms:0,
                'booking_completed_sms' => (isset($request->completed_sms))?$request->completed_sms:0,
                'booking_cancelled_sms' => (isset($request->cancelled_sms))?$request->cancelled_sms:0,
                'booking_refund_sms' => (isset($request->refund_sms))?$request->refund_sms:0,
                'user_id' => auth()->user()->id,
                'status' => 'active',
                'created_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_by' => auth()->user()->id,
                'updated_at' => Carbon::now(),
            ]);

            // return redirect()->route('notification-setting')->with('success', 'Saved successfully');

            $data = [
                'message' => "Saved successfully",
                'status'=>1
            ];
            return response()->json($data);
        }
    }
}
