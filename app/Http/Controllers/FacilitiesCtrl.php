<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facilities;
use App\Models\HotelFacilities;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class FacilitiesCtrl extends Controller
{
    // load view Facilities list
    public function index(Request $request)
    {
        $query = Facilities::where('status', '!=', 'deleted');
        $query->select(['*']);
             
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->where('facility_name', 'LIKE', "%{$keyword}%");

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
        
        return view('admin.facilities_list')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'dates'=>$dates]);
    }

    // load view facilities add/edit
    public function facilitiesInput($id=0)
    {
        if($id == 0 || $id == 'new') 
            return view('admin.facilities_input');
        else
        {
            $facilitie = Facilities::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            return view('admin.facilities_input')->with(['facilitie'=>$facilitie]);
        }
    }

    // facilities-Input submit 
    public function facilitiesInputSubmit(Request $request)
    {
        $facility_name = strtolower($request->facility_name);
        $isFacilitieExist = Facilities::where('id', '!=', $request->id)->where('facility_name', '=', $facility_name)->where('status', '!=', 'deleted')->count();

        if($isFacilitieExist > 0)
        {
            $data = [
                'status' => 0,
                'message' => 'Facilitie already exist',
            ];

            return response()->json($data);
        }
        else
        {
            if($request->id == 0)
            {
                $newFacilities= Facilities::create([
                    'facility_name' => $facility_name,
                    'created_by'=>auth()->user()->id,
                    'updated_by'=>auth()->user()->id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),          
                ]);
                
                if($newFacilities)
                {
                    $nextpageurl = route('facilities-list');
            
                    $data = [
                        'status' => 1,
                        'message' => 'Facilitie added successfully',
                        'nextpageurl'=>$nextpageurl
                    ];

                    return response()->json($data);
                }
            
            }
            else
            {
                $facilitie = Facilities::where('id', '=', $request->id)->where('status', '!=', 'deleted')->first();

                if($facilitie)
                {
                    $facilitie->facility_name = $facility_name;
                    $facilitie->updated_by = auth()->user()->id;
                    $facilitie->updated_at = Carbon::now();
                    $facilitie->save();

                    $nextpageurl = route('facilities-list');
                    $data = [
                        'status' => 1,
                        'message' => 'Facilitie updated successfully',
                        'nextpageurl'=>$nextpageurl
                    ];

                    return response()->json($data);
                    
                }

            }
        }
        
    }

    // facilitie statuc action active/inactive/delete
    public function facilitiesStatus($id,$status)
    {
        // dd($id,$status);    
        $isFacilitieExist = HotelFacilities::where('facilities_id', '=', $id)->where('status', '!=', 'deleted')->where('status', '!=', 'deleted')->count();


        if($isFacilitieExist > 0 && $status =='active')
        {
            return redirect()->route('facilities-list')->with('error_msg','This Facilitie can not delete/inactive becouse hotel is using this facilitie');
        }
        else
        {
            $facilitie = Facilities::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            if($facilitie)
            {
                if($status =='deleted')
                {
                    $facilitie->status = $status;
                    $facilitie->updated_by = auth()->user()->id;
                    $facilitie->updated_at = Carbon::now();
                    $facilitie->save();
                    return redirect()->route('facilities-list')->with('success_msg','Facilities '.$status.' successfully');
                }
                elseif($status =='active' || $status =='inactive')
                {
                    $status = ($status =='active')?'inactive':'active'; 
                    $facilitie->status = $status;
                    $facilitie->save();
                    return redirect()->route('facilities-list')->with('success_msg','Facilities '.$status.' successfully');
                }
                else
                {
                    return redirect()->route('facilities-list')->with('error_msg','Invalid status');
                }
            }
            else
                return redirect()->route('facilities-list')->with('error_msg','Invalid Facilitie');            
        }

    }
    
}
