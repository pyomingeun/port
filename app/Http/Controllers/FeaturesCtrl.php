<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Features;
use App\Models\HotelFeatures;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class FeaturesCtrl extends Controller
{
    // load view features list
    public function index(Request $request)
    {
        $query = Features::where('status', '!=', 'deleted');
        $query->select(['*']);
                
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->where('feature_name', 'LIKE', "%{$keyword}%");

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
        
        return view('admin.features_list')->with(['list'=>$list,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status,'dates'=>$dates]);
    }

    // load view Features add/edit
    public function featuresInput($id=0)
    {
        if($id == 0 || $id == 'new') 
            return view('admin.features_input');
        else
        {
            $feature = Features::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            return view('admin.features_input')->with(['feature'=>$feature]);
        }
    }

    // Features-Input submit 
    public function featuresInputSubmit(Request $request)
    {
        //dd($request->all());
        $feature_name = strtolower($request->amenitie_name);
        $isfeatureExist = Features::where('id', '!=', $request->id)->where('feature_name', '=', $feature_name)->where('status', '!=', 'deleted')->count();

        if($isfeatureExist > 0)
        {
            $data = [
                'status' => 0,
                'message' => 'This Amenitie is already exist',
            ];

            return response()->json($data);
        }
        else
        {
            if($request->id == 0)
            {
                $newFeatures= Features::create([
                    'feature_name' => $feature_name,
                    'feature_icon' => $request->icon,
                    'created_by'=>auth()->user()->id,
                    'updated_by'=>auth()->user()->id,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),          
                ]);
                
                if($newFeatures)
                {
                    $nextpageurl = route('amenities-list');
            
                    $data = [
                        'status' => 1,
                        'message' => 'Amenitie added successfully',
                        'nextpageurl'=>$nextpageurl
                    ];

                    return response()->json($data);
                }
            
            }
            else
            {
                $feature = Features::where('id', '=', $request->id)->where('status', '!=', 'deleted')->first();

                if($feature)
                {
                    $feature->feature_name = $feature_name;
                    $feature->feature_icon = $request->icon;
                    $feature->updated_by = auth()->user()->id;
                    $feature->updated_at = Carbon::now();
                    $feature->save();

                    $nextpageurl = route('amenities-list');
                    $data = [
                        'status' => 1,
                        'message' => 'Amenitie updated successfully',
                        'nextpageurl'=>$nextpageurl
                    ];

                    return response()->json($data);
                    
                }

            }
        }
        
    }

    // feature statuc action active/inactive/delete
    public function featuresStatus($id,$status)
    {
        // dd($id,$status);    
        $isFeatureExist = HotelFeatures::where('features_id', '=', $id)->where('status', '!=', 'deleted')->where('status', '!=', 'deleted')->count();


        if($isFeatureExist > 0 && $status =='active')
        {
            return redirect()->route('amenities-list')->with('error_msg','This feature can not delete/inactive becouse hotel is using this feature');
        }
        else
        {
            $feature = Features::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            if($feature)
            {
                if($status =='deleted')
                {
                    $feature->status = $status;
                    $feature->updated_by = auth()->user()->id;
                    $feature->updated_at = Carbon::now();
                    $feature->save();
                    return redirect()->route('amenities-list')->with('success_msg','Amenitie '.$status.' successfully');
                }
                elseif($status =='active' || $status =='inactive')
                {
                    $status = ($status =='active')?'inactive':'active'; 
                    $feature->status = $status;
                    $feature->save();
                    return redirect()->route('amenities-list')->with('success_msg','Amenitie '.$status.' successfully');
                }
                else
                {
                    return redirect()->route('amenities-list')->with('error_msg','Invalid status');
                }
            }
            else
                return redirect()->route('amenities-list')->with('error_msg','Invalid Amenitie');            
        }

    }

    // upload icon    
    public function uploadFeatureIcon(Request $request)
    {
        // $whereHotel =array('hotel_id'=>$request->id);
        // $hotel = HotelInfo::where($whereHotel)->first();
        // if($hotel)
        // {
            // $folderPath = public_path('hotel_logo/');
            $folderPath = 'feature_icon/';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $logo = uniqid() . '.png';
            $file = $folderPath . $logo;
    
            file_put_contents($file, $image_base64);
            // $hotel->templogo = $logo;
            // $hotel->save();
            return response()->json(['status'=>1,'message'=>'updated successfully','logo'=>$logo]);
        // }
        // else
        // {
        //     return response()->json(['status'=>0,'message'=>'Something went wrong']);
        // }
    }

    // delete hotel logo     
    public function delHotelLogo(Request $request)
    {
        $whereHotel =array('hotel_id'=>$request->id);
        // $hotel = HotelInfo::where($whereHotel)->first();
        if($hotel)
        {
            $hotel->templogo = '';
            // $hotel->logo = '';
            $hotel->save();
            return response()->json(['status'=>1,'message'=>'Deleted successfully']);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }                          
    }
}
