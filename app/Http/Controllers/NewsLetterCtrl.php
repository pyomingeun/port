<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLetter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class NewsLetterCtrl extends Controller
{

    public function index(Request $request)
    {
        //
        $query = NewsLetter::where('status', '!=', 'deleted');
        // $query->where('status', '=', $request->status);
        $query->select(['*']);
                
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->where('email', 'LIKE', "%{$keyword}%");
        }
        
        if($request->status !='')
        {
            $query->where('status', '=', $request->status);
        }

        $query->get();

        $c = (isset($request->c) && $request->c !='')?$request->c:'id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        $dates = (isset($request->dates) && $request->dates !='')?$request->dates:'';
        $query->orderBy($c,$o);
        $list = $query->paginate(8);
        $exportRows = [];
        $todayFullDateTime = date_format(Carbon::now(),"Y-m-d-H-m-s");

        $filename = 'subscribers_'.$todayFullDateTime;
        $exportRows[0] = ['Email', 'Subscribed On'];
        for($i=0; $i < count($list); $i++)
        {
            $created_atDate=date_create($list[$i]->created_at);
            $created_at = date_format($created_atDate,"Y-m-d");

            $exportRows[$i+1] = [$list[$i]->email,$created_at]; 
        }

        return view('admin.newsletter_list')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'dates'=>$dates,'exportRows'=>$exportRows,'filename'=>$filename]);
    }

    public function status($id,$status)
    {
        $subsriber = NewsLetter::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
        if($status =='deleted')
        {
            $subsriber->status = $status;
            $subsriber->updated_by = auth()->user()->id;
            $subsriber->updated_at = Carbon::now();
            $subsriber->save();
            return redirect()->route('newsletter-list')->with('success_msg','Subscriber '.$status.' successfully');
        }
        elseif($status =='active' || $status =='inactive')
        {
            $status = ($status =='active')?'inactive':'active'; 
            $subsriber->status = $status;
            $subsriber->save();
            return redirect()->route('newsletter-list')->with('success_msg','Subscriber '.$status.' successfully');
        }
        else
        {
            return redirect()->route('newsletter-list')->with('error_msg','Invalid status');
        }
    }

    public function subscribe(Request $request)
    {
        $user_id = (auth()->user())?auth()->user()->id:0;
        $data = subsribeUs($request->subscribe_email,$user_id);
        return $data;
    }

    public function unSubscribe(Request $request)
    {
        $isExist = NewsLetter::where('slug', '=', $request->slug)->where('status', '=', 'active')->where('is_subscribed', '=', '1')->count();

        if($isExist > 0)
        {
            $isExist->is_subscribed = 0;
            $isExist->status = 'deleted';
            $isExist->updated_by = auth()->user()->id;
            $isExist->updated_at = Carbon::now();
            $isExist->save();

            $data = [
                'status' => 1,
                'message' => 'You are successfully unsubscribed.'
            ];
            return response()->json($data);
        
        }
        else
        {
            $data = [
                'status' => 0,
                'message' => 'You are already unsubscribed.'
            ];
            return response()->json($data);
        }

    }

    
}