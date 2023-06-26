<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminGlobalVariable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class SystemConfigurationCtrl extends Controller
{

    // 
    public function index(Request $request)
    {
        $query = AdminGlobalVariable::where('status', '!=', 'deleted');
        $query->select(['*']);
             
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->whereNested(function($query) use ($keyword) {
                $query->where('value_for', 'LIKE', "%{$keyword}%");
                $query->orWhere('value_type', 'LIKE', "%{$keyword}%");
            });
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
        
        return view('admin.system_configuration')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'dates'=>$dates]);
    }

    // update admin golable values 
    public function SystemConfigurationCtrl($type)
    {
        $row = AdminGlobalVariable::where('type', '=', $type)->where('status', '!=', 'deleted')->first();
        if($row)
            return view('admin.system_configuration_edit')->with(['row'=>$row]);
        else    
            return redirect()->route('system-configuration-list')->with('error_msg','Some thing went wrong.');
    }

    // update admin golable values 
    public function systemConfigurationUpdate(Request $request)
    {
        $row = AdminGlobalVariable::where('type', '=', $request->type)->where('status', '!=', 'deleted')->first();

        if($row)
        {
            $row->value_for = $request->value_for;
            $row->value = $request->value;
            $row->save();

            $nextpageurl = route('system-configuration-list');
            $data = [
                'status' => 1,
                'url'=>'',
                'nextpageurl'=>$nextpageurl
            ];
        }
        else
        {
            $data = [
                'status' => 0,
                'url'=>'',
                'message'=>'Something went wrong.'
            ];    
        }
        return response()->json($data);
    }

}
