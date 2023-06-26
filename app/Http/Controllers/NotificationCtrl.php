<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class NotificationCtrl extends Controller
{
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $query = Notification::where('status', '=', 'active');
        $query->where('user_id', '=', $user_id);
        $query->select(['*']);
             
        if($request->status !='')
        {
            $query->where('status', '=', $request->status);
        }

        

        $c = (isset($request->c) && $request->c !='')?$request->c:'id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        $dates = (isset($request->dates) && $request->dates !='')?$request->dates:'';
        $query->orderBy($c,$o);
        $list = $query->get();
        // $list = $query->paginate(8); 
        // echo "<pre>"; print_r($list); die;  

        $res = Notification::where("user_id", $user_id)->where("read",'=', 0)->update(["read" => "1"]);
        
        return view('notification.notification_list')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'dates'=>$dates]);
    }
}
