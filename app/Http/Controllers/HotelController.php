<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\HotelInfo;
use App\Models\HotelFacilities;
use App\Models\HotelFeatures;
use App\Models\Facilities;
use App\Models\Features;
use App\Models\NearestTouristAttractions;
use App\Models\HotelExtraServices;
use App\Models\LongStayDiscount;
use App\Models\HotelPeakSeason;
use App\Models\HotelBankAcDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use App\Models\RoomFacilities;
use App\Models\RoomFeatures;
// use Illuminate\Support\Facades\Crypt;

class HotelController extends Controller
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
    
    public function hm_cancel(){
        
        if(auth()->user()->access == 'admin')  
            return redirect()->route('hotel_managment');
        else    
            return redirect()->route('dashboard');     

    }
    // step 1 view basic info view load 
    public function hm_basic_info($id)
    {
        $id = $id;// base64_decode($id); //encrypt($id);
        $hotel = HotelInfo::with('hasImage')->where('hotel_id', '=', $id)->first();
        // dd($hotel);
        if($hotel)
        {
            $hotel->templogo = $hotel->logo;
            $hotel->save();
            return view('hotel.hotel_managment_s1',compact('hotel'));
        }
        else
            return redirect()->route('dashboard');
                  
    }

    // step 1 submit basic info 
    public function hm_basic_info_submit(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $credentials =array('hotel_id'=>$request->h);
            $hotel = HotelInfo::where($credentials)->first();

            if($hotel)
            {
                $hotel->logo = $hotel->templogo;
                $hotel->hotel_name = $request->hotel_name;
                $hotel->description = $request->hotel_description;
                if($hotel->basic_info_status == 0)
                {
                    $hotel->basic_info_status = 1;
                    $hotel->completed_percentage = $hotel->completed_percentage +20;
                }
                
                $hotel->save();

                $whereUser =array('id'=>$request->h);
                $user = User::where($whereUser)->first();

                if($user)
                {
                    $user->full_name = $request->hotel_name;
                    $user->save();
                }

                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_addressNAttractions', ['id' => $request->h]);
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }  
    }

    // step 2 
    public function hm_addressNAttractions($id)
    {
        // echo "full_name".auth()->user()->full_name; die; 
        $hotel = HotelInfo::with('hasAttractions')->where('hotel_id', '=', $id)->first();
        // dd($hotel);
        if($hotel)
        {
             return view('hotel.hotel_managment_s2',compact('hotel'));
        }
        else
            return redirect()->route('dashboard');
    }

    // hm step2 submit 
    public function hm_addressNAttractions_submit(Request $request)
    {
        // dd($request->all());
        // dd($request->hotel_description);
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $credentials =array('hotel_id'=>$request->h);//  ,$request->field=>$request->val
            $hotel = HotelInfo::where($credentials)->first();

            if($hotel)
            {
                $hotel->latitude = ($request->latitude !='')?$request->latitude:'';
                $hotel->longitude = ($request->longitude !='')?$request->longitude:'';
                $hotel->formatted_address = $request->address;
                $hotel->sido = $request->sido;
                $hotel->sigungu = $request->sigungu;
                $hotel->areacode = $request->areacode;
                $hotel->phone = $request->phone;
                if($hotel->address_status == 0)
                {
                    $hotel->address_status = 1;
                    $hotel->completed_percentage = $hotel->completed_percentage +15;
                }
                $hotel->save();
                
                $counter = (isset($request->attraction_name) && count($request->attraction_name) >0)?count($request->attraction_name):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {
                        if($request->rid[$i] == 0)
                        {
                            $newNTA = NearestTouristAttractions::create([
                                'hotel_id' => $request->h,
                                'attractions_name' => $request->attraction_name[$i],
                                'nta_address' => $request->attraction_adres[$i],
                                'nta_latitude' => ($request->nta_latitude[$i]!='')?$request->nta_latitude[$i]:'',
                                'nta_longitude' => ($request->nta_longitude[$i]!='')?$request->nta_longitude[$i]:'',
                                'nta_description' => $request->attraction_desc[$i],
                                'status' =>'active',
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        else
                        {
                            $whereRow =array('hotel_id'=>$request->h,'id'=>$request->rid[$i]);
                            $row = NearestTouristAttractions::where($whereRow)->first(); 
                            if($row)
                            {
                                $row->updated_by = auth()->user()->id;
                                $row->updated_at = Carbon::now();
                                $row->attractions_name = $request->attraction_name[$i];
                                $row->nta_address = $request->attraction_adres[$i];
                                $row->nta_longitude = ($request->nta_latitude[$i]!='')?$request->nta_latitude[$i]:'';
                                $row->nta_longitude = ($request->nta_longitude[$i]!='')?$request->nta_longitude[$i]:'';
                                $row->nta_description = $request->attraction_desc[$i];
                                $row->status = 'active';
                                $row->save();  
                            }
                        }
                        
                    }                                            
                }
                
                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_policies', ['id' => $request->h]);
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }  
    }

    // step 3
    public function hm_policies($id)
    {
        $hotel = HotelInfo::where('hotel_id', '=', $id)->first();
        if($hotel)
        {
             return view('hotel.hm_policies',compact('hotel'));
        }
        else
            return redirect()->route('dashboard');
    }

    // setp 3 submit
    public function hm_policies_submit(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $credentials =array('hotel_id'=>$request->h);
            $hotel = HotelInfo::where($credentials)->first();

            if($hotel)
            {
                $hotel->check_in = $request->check_in;
                $hotel->check_out = $request->check_out;
                $hotel->hotel_policy = $request->hotel_policy;
                $hotel->terms_and_conditions = (isset($request->terms_and_conditions))?$request->terms_and_conditions:'';
                $hotel->same_day_refund = (isset($request->same_day_refund) && $request->same_day_refund !='')?$request->same_day_refund:0;
                $hotel->b4_1day_refund = (isset($request->b4_1day_refund) && $request->b4_1day_refund !='')?$request->b4_1day_refund:0;
                $hotel->b4_2days_refund = (isset($request->b4_2days_refund) && $request->b4_2days_refund !='')?$request->b4_2days_refund:0;
                $hotel->b4_3days_refund = (isset($request->b4_3days_refund) && $request->b4_3days_refund !='')?$request->b4_3days_refund:0;
                $hotel->b4_4days_refund = (isset($request->b4_4days_refund) && $request->b4_4days_refund !='')?$request->b4_4days_refund:0;
                $hotel->b4_5days_refund = (isset($request->b4_5days_refund) && $request->b4_5days_refund !='')?$request->b4_5days_refund:0;   
                $hotel->b4_6days_refund = (isset($request->b4_6days_refund) && $request->b4_6days_refund !='')?$request->b4_6days_refund:0;
                $hotel->b4_7days_refund = (isset($request->b4_7days_refund) && $request->b4_7days_refund !='')?$request->b4_7days_refund:0;
                $hotel->b4_8days_refund = (isset($request->b4_8days_refund) && $request->b4_8days_refund !='')?$request->b4_8days_refund:0;
                $hotel->b4_9days_refund = (isset($request->b4_9days_refund) && $request->b4_9days_refund !='')?$request->b4_9days_refund:0;
                $hotel->b4_10days_refund = (isset($request->b4_10days_refund) && $request->b4_10days_refund !='')?$request->b4_10days_refund:0;
                $hotel->min_advance_reservation = (isset($request->min_advance_reservation) && $request->min_advance_reservation !='')?$request->min_advance_reservation:0;
                $hotel->max_advance_reservation = (isset($request->max_advance_reservation) && $request->max_advance_reservation !='')?$request->max_advance_reservation:0;
                if($hotel->hpolicies_status == 0)
                {
                    $hotel->hpolicies_status = 1;
                    $hotel->completed_percentage = $hotel->completed_percentage +20;
                }
                $hotel->save();

                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_FeaturesNFacilities', ['id' => $request->h]);
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }        
    }

    // step 4 Features & Facilities
    public function hm_FeaturesNFacilities($id)
    {
        $query = HotelFacilities::join('facilities', 'facilities.id', '=', 'hotel_facilities.facilities_id');
        $query->where('facilities.status', '!=', 'deleted');
        $query->where('hotel_facilities.status', '!=', 'deleted');
        $query->where('hotel_facilities.hotel_id', '=', $id);
        $query->select(['facilities.facilities_name', 'hotel_facilities.*']);
        $hotel_facilities = $query->get();

        $query2 = HotelFeatures::join('features', 'features.id', '=', 'hotel_features.features_id');
        $query2->where('features.status', '!=', 'deleted');
        $query2->where('hotel_features.status', '!=', 'deleted');
        $query2->where('hotel_features.hotel_id', '=', $id);
        $query2->select(['features.features_name', 'hotel_features.*']);
        $hotel_features = $query2->get();

        $facilities = Facilities::where('status', '=', 'active')->select('*')->get();
        $features = Features::where('status', '=', 'active')->select('*')->get();
        
        $selected_features_ids = DB::select("select GROUP_CONCAT(DISTINCT(features_id)) as ids from hotel_features WHERE hotel_id='".$id."' AND status !='deleted'");
        $selected_facilities_ids = DB::select("select GROUP_CONCAT(DISTINCT(facilities_id)) as ids from hotel_facilities WHERE hotel_id='".$id."' AND status !='deleted'");
        
        // ".$id."
        $features_ids = array();
        $facilities_ids = array();
        if($selected_features_ids !='' && $selected_features_ids !=null && $selected_features_ids !=false)
        {
            $features_ids = explode(",",$selected_features_ids[0]->ids);
        } 
        if($selected_facilities_ids !='' && $selected_facilities_ids !=null && $selected_facilities_ids !=false)
        {
            $facilities_ids = explode(",",$selected_facilities_ids[0]->ids);
        }  
                      
        $hotel = HotelInfo::where('hotel_id', '=', $id)->first();
        if($hotel)
        {
             return view('hotel.hm_features_n_facilities')->with(['hotel'=>$hotel,'features'=>$features,'facilities'=>$facilities,'hotel_features'=>$hotel_features,'hotel_facilities'=>$hotel_facilities,'features_ids'=>$features_ids,'facilities_ids'=>$facilities_ids]);

        }
        else
            return redirect()->route('dashboard');
    }

    // next of step 4 
    public function hm_feNfa_submit(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $credentials =array('hotel_id'=>$request->h);//  ,$request->field=>$request->val
            $hotel = HotelInfo::where($credentials)->first();

            if($hotel)
            {
                // delete and insert features 
                $res = HotelFeatures::where("hotel_id", $request->h)->update(["status" => "deleted"]);
                    
                $counter = (isset($request->features) && count($request->features) >0)?count($request->features):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {
                        $whereHotelFeatuer =array('features_id'=>$request->features[$i],'hotel_id'=>$request->h);
                        $is_feature_exist = HotelFeatures::where($whereHotelFeatuer)->first(); 
                        
                        if($is_feature_exist)
                        {
                            $is_feature_exist->status = 'active';
                            $is_feature_exist->save();
                        }
                        else
                        {
                            $newFeature = HotelFeatures::create([
                                'hotel_id' => $request->h,
                                'features_id' => $request->features[$i], //$request->email,
                                'status' =>'active',
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);                                   
                        }
                    }    
                }
                
                // delete and insert facilities 
                $res = HotelFacilities::where("hotel_id", $request->h)->update(["status" => "deleted"]);
                    
                $counter = (isset($request->facilities) && count($request->facilities) >0)?count($request->facilities):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {
                        $whereHotelFacilities =array('facilities_id'=>$request->facilities[$i],'hotel_id'=>$request->h);
                        $is_facilitie_exist = HotelFacilities::where($whereHotelFacilities)->first(); 
                        
                        if($is_facilitie_exist)
                        {
                            $is_facilitie_exist->status = 'active';
                            $is_facilitie_exist->save();
                        }
                        else
                        {
                            $newFeature = HotelFacilities::create([
                                'hotel_id' => $request->h,
                                'facilities_id' => $request->facilities[$i], //$request->email,
                                'status' =>'active',
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);                                   
                        }
                    }    
                }

                // $nextpageurl = route('forgot_password_success');
                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_otherInfo', ['id' => $request->h]);

                if($hotel->fnf_status == 0)
                {
                    $hotel->fnf_status = 1;
                    $hotel->completed_percentage = $hotel->completed_percentage +15;
                    $hotel->save();
                }    
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }   
    }

    // select feature
    public function select_features(Request $request)
    {
        // $request->i means features_id & $request->h means hotel_id
        $whereFeature =array('id'=>$request->i,'status'=>'active');
        $feature = Features::where($whereFeature)->first();

        $whereHotelFeatuer =array('features_id'=>$request->i,'hotel_id'=>$request->h);
        $is_exist = HotelFeatures::where($whereHotelFeatuer)->first();
        
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            if($is_exist)
            {
                if($is_exist->status == 'deleted')
                {
                    $is_exist->updated_by = auth()->user()->id;
                    $is_exist->updated_at = Carbon::now();
                    $is_exist->status = 'active';
                    $is_exist->save();
                    $data = [
                        'status' => 1,
                        'message' => 'saved successfully.',
                        'chip'=>'<p class="selectchip delete_feature" data-ri="'.$is_exist->id.'" data-h="'.$is_exist->hotel_id.'" id="feature_chip_'.$is_exist->id.'" >'.$feature->features_name.'<span class="closechps">×</span></p>'
                    ];
                    return response()->json($data);
                }
                else
                {
                    $data = [
                        'status' => 0,
                        'message'=>'This feature is already in your selected features list.'
                    ];
                    return response()->json($data);
                }
            }
            else
            {
                $newFeature = HotelFeatures::create([
                    'hotel_id' => $request->h,
                    'features_id' => $request->i, //$request->email,
                    'status' =>'draft',
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                if($newFeature)
                {
                    $data = [
                        'status' => 1,
                        'message' => 'saved successfully.',
                        'chip'=>'<p class="selectchip delete_feature" data-ri="'.$newFeature->id.'" data-h="'.$newFeature->hotel_id.'" id="feature_chip_'.$newFeature->id.'" >'.$feature->features_name.'<span class="closechps">×</span></p>'
                    ];
                    return response()->json($data);
                }
                else
                {   
                    $data = [
                        'status' => 0,
                        'message'=>'you are not authorized.'
                    ];
                    return response()->json($data);
                }
            }
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }
            
    }

    // select facilities
    public function select_facilities(Request $request)
    {
        // $request->i means features_id & $request->h means hotel_id
        $wherefacilities =array('id'=>$request->i,'status'=>'active');
        $facilitie = Facilities::where($wherefacilities)->first();

        $whereHotelFacilitie =array('facilities_id'=>$request->i,'hotel_id'=>$request->h);
        $is_exist = HotelFacilities::where($whereHotelFacilitie)->first();
        
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            if($is_exist)
            {
                if($is_exist->status == 'deleted')
                {
                    $is_exist->updated_by = auth()->user()->id;
                    $is_exist->updated_at = Carbon::now();
                    $is_exist->status = 'active';
                    $is_exist->save();
                    $data = [
                        'status' => 1,
                        'message' => 'saved successfully.',
                        'chip'=>'<p class="selectchip delete_facilitie" data-ri="'.$is_exist->id.'" data-h="'.$is_exist->hotel_id.'" id="facilitie_chip_'.$is_exist->id.'" >'.$facilitie->facilities_name.'<span class="closechps">×</span></p>'
                    ];
                    return response()->json($data);
                }
                else
                {
                    $data = [
                        'status' => 0,
                        'message'=>'This facilitie is already in your selected facilities list.'
                    ];
                    return response()->json($data);
                }

            }
            else
            {
                $newFacilitie = HotelFacilities::create([
                    'hotel_id' => $request->h,
                    'facilities_id' => $request->i, //$request->email,
                    'status' =>'draft',
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                if($newFacilitie)
                {
                    $data = [
                        'status' => 1,
                        'message' => 'saved successfully.',
                        'chip'=>'<p class="selectchip delete_facilitie" data-ri="'.$newFacilitie->id.'" data-h="'.$newFacilitie->hotel_id.'" id="facilitie_chip_'.$newFacilitie->id.'" >'.$facilitie->facilities_name.'<span class="closechps">×</span></p>'
                    ];
                    return response()->json($data);
                }
                else
                {   
                    $data = [
                        'status' => 0,
                        'message'=>'you are not authorized.'
                    ];
                    return response()->json($data);
                }
            }
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }
        
    }

    // delete feature
    public function delete_feature(Request $request)
    {
        // $request->ri means row id & $request->h means hotel_id
        
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            $isUsedInRoom = RoomFeatures::where('hotel_id','=',$request->h)->where('features_id','=',$request->fi)->where('status','=','active')->count();
            if($isUsedInRoom == 0)
            {
                $credentials =array('features_id'=>$request->fi,'hotel_id'=>$request->h);
                $row = HotelFeatures::where($credentials)->first();
                if($row)
                {
                    $row->updated_by = auth()->user()->id;
                    $row->updated_at = Carbon::now();
                    $row->status = 'deleted';
                    $row->save();
                    $data = [
                        'status' => 1,
                        'message' => 'deleted successfully.'
                    ];
                    return response()->json($data); 
                }
                else
                {   
                    $data = [
                        'status' => 0,
                        'message'=>'you are not authorized.'
                    ];
                    return response()->json($data);
                }    
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>"This feature is not able to delete becouse it's used in room."
                ];
                return response()->json($data);                
            }
            
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }
    }

    // delete facilities
    public function delete_facilitie(Request $request)
    {
        // $request->ri means row id & $request->h means hotel_id
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            $isUsedInRoom = RoomFacilities::where('hotel_id','=',$request->h)->where('facilities_id','=',$request->fi)->where('status','=','active')->count();
            if($isUsedInRoom == 0)
            {
                $credentials =array('facilities_id'=>$request->fi,'hotel_id'=>$request->h);
                $row = HotelFacilities::where($credentials)->first();

                if($row)
                {
                    $row->updated_by = auth()->user()->id;
                    $row->updated_at = Carbon::now();
                    $row->status = 'deleted';
                    $row->save();
                    $data = [
                        'status' => 1,
                        'message' => 'deleted successfully.'
                    ];
                    return response()->json($data); 
                }
                else
                {   
                    $data = [
                        'status' => 0,
                        'message'=>'you are not authorized.'
                    ];
                    return response()->json($data);
                }
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>"This facilities is not able to delete becouse it's used in room."
                ];
                return response()->json($data);                
            }    

        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }
    }


    // step 5 other-Info
    public function hm_otherInfo($id)
    {
        $hotel = HotelInfo::with('hasExtraServices')->with('hasLongStayDiscount')->with('hasPeakSeasont')->where('hotel_id', '=', $id)->first();
        // dd($hotel);
        if($hotel)
        {
             return view('hotel.hm_other_info',compact('hotel'));
        }
        else
            return redirect()->route('dashboard');
    }

    // next of step 5
    public function hm_otherInfo_submit(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $credentials =array('hotel_id'=>$request->h);
            $hotel = HotelInfo::where($credentials)->first();

            if($hotel)
            {
                // insert/update extra services 
                $counter = (isset($request->es_name) && count($request->es_name) >0)?count($request->es_name):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {
                        if($request->esid[$i] == 0)
                        {
                            $newNTA = HotelExtraServices::create([
                                'hotel_id' => $request->h,
                                'es_name' => $request->es_name[$i],
                                'es_price' => $request->es_price[$i],
                                'es_max_qty' => $request->es_max_qty[$i],
                                'status' =>'active',
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        else
                        {
                            $whereRow =array('hotel_id'=>$request->h,'id'=>$request->esid[$i]);
                            $row = HotelExtraServices::where($whereRow)->first(); 
                            if($row)
                            {
                                $row->updated_by = auth()->user()->id;
                                $row->updated_at = Carbon::now();
                                $row->es_name = $request->es_name[$i];
                                $row->es_price = $request->es_price[$i];
                                $row->es_max_qty = $request->es_max_qty[$i];
                                $row->status = 'active';
                                $row->save();  
                            }
                        }
                        
                    }                                            
                }
                // close 

                // insert/update long stay discount services 
                $counter = (isset($request->lsd_min_days) && count($request->lsd_min_days) >0)?count($request->lsd_min_days):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {
                        if($request->lsdid[$i] == 0)
                        {
                            $key = 'lsd_discount_typenew'.$request->newrow[$i];

                            if($request->$key[0] == 'percentage' && $request->lsd_discount_amount[$i] > 100)
                                $lsd_discount_amount = 100;    
                            else
                                $lsd_discount_amount = $request->lsd_discount_amount[$i];

                            $newNTA = LongStayDiscount::create([
                                'hotel_id' => $request->h,
                                'lsd_min_days' => $request->lsd_min_days[$i],
                                'lsd_max_days' => $request->lsd_max_days[$i],
                                'lsd_discount_amount' => $lsd_discount_amount,
                                'lsd_discount_type' => $request->$key[0],
                                'status' =>'active',
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        else
                        {
                            $whereRow =array('hotel_id'=>$request->h,'id'=>$request->lsdid[$i]);
                            $row = LongStayDiscount::where($whereRow)->first(); 
                            if($row)
                            {
                                $key = 'lsd_discount_type'.$request->lsdid[$i];
                                if($request->$key[0] == 'percentage' && $request->lsd_discount_amount[$i] > 100)
                                    $row->lsd_discount_amount = 100;    
                                else
                                    $row->lsd_discount_amount = $request->lsd_discount_amount[$i];

                                $row->updated_by = auth()->user()->id;
                                $row->updated_at = Carbon::now();
                                $row->lsd_min_days = $request->lsd_min_days[$i];
                                $row->lsd_max_days = $request->lsd_max_days[$i];
                                $row->lsd_discount_type =  $request->$key[0];
                                $row->status = 'active';
                                $row->save();  
                            }
                        }
                        
                    }                                            
                }
                // close

                // insert/update peak season 
                $counter = (isset($request->season_name) && count($request->season_name) >0)?count($request->season_name):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {
                        $date1=date_create($request->start_date[$i]);
                        $start_date = date_format($date1,"Y-m-d");

                        $date2=date_create($request->end_date[$i]);
                        $end_date = date_format($date2,"Y-m-d");

                        if($request->psid[$i] == 0)
                        {
                            $newNTA = HotelPeakSeason::create([
                                'hotel_id' => $request->h,
                                'season_name' => $request->season_name[$i],
                                'start_date' => $start_date,
                                'end_date' => $end_date,
                                'status' =>'active',
                                'created_by' => auth()->user()->id,
                                'updated_by' => auth()->user()->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        else
                        {
                            $whereRow =array('hotel_id'=>$request->h,'id'=>$request->psid[$i]);
                            $row = HotelPeakSeason::where($whereRow)->first(); 
                            if($row)
                            {
                                $row->updated_by = auth()->user()->id;
                                $row->updated_at = Carbon::now();
                                $row->season_name = $request->season_name[$i];
                                $row->start_date = $start_date;
                                $row->end_date = $end_date;
                                $row->status = 'active';
                                $row->save();  
                            }
                        }
                        
                    }                                            
                }
                // close

                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_bankinfo', ['id' => $request->h]);
                if($hotel->other_info_status == 0)
                {
                    $hotel->other_info_status = 1;
                    $hotel->completed_percentage = $hotel->completed_percentage +15;
                    $hotel->save();
                }    
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }   
    }

    
    // step 6 summary
    public function hm_summary($id)
    {
        // ->with('hasFeatures')->with('hasFacilities')
        $hotel = HotelInfo::with('hasImageActive')->with('hasAttractions')->with('hasExtraServices')->with('hasLongStayDiscount')->with('hasPeakSeasont')->with('hasHotelBankAcDetails')->where('hotel_id', '=', $id)->first();
        if($hotel)
        {
            $query = HotelFacilities::join('facilities', 'facilities.id', '=', 'hotel_facilities.facilities_id');
            $query->where('facilities.status', '!=', 'deleted');
            $query->where('hotel_facilities.status', '!=', 'deleted');
            $query->where('hotel_facilities.hotel_id', '=', $id);
            $query->select(['facilities.facilities_name', 'hotel_facilities.*']);
            $hotel_facilities = $query->get();
    
            $query2 = HotelFeatures::join('features', 'features.id', '=', 'hotel_features.features_id');
            $query2->where('features.status', '!=', 'deleted');
            $query2->where('hotel_features.status', '!=', 'deleted');
            $query2->where('hotel_features.hotel_id', '=', $id);
            $query2->select(['features.features_name', 'hotel_features.*']);
            $hotel_features = $query2->get();
             return view('hotel.hm_summary')->with(['hotel'=>$hotel,'hotel_facilities'=>$hotel_facilities,'hotel_features'=>$hotel_features]);
        }
        else
            return redirect()->route('dashboard');
    }

    // next of step 6
    public function hm_summary_submit(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $credentials =array('hotel_id'=>$request->h);
            $hotel = HotelInfo::where($credentials)->first();

            if($hotel)
            {
                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_bankinfo', ['id' => $request->h]);

                if($hotel->summary_status == 0)
                {
                    $hotel->summary_status = 1;
                    $hotel->save();
                }    
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
            ];
            return response()->json($data);
        }   
    }
    
     // step 7 bank details view
     public function hm_bankinfo($id)
     {
         if(auth()->user()->access == 'admin' || (auth()->user()->id == $id))
         {
            $hotel = HotelInfo::with('hasHotelBankAcDetails')->where('hotel_id', '=', $id)->first();
            // $hotel = HotelBankAcDetails::where('hotel_id', '=', $id)->first();
            if($hotel)
            {
                return view('hotel.hm_bank_ac_details',compact('hotel'));
            }
            else
                return redirect()->route('dashboard');  
         }
         else
             return redirect()->route('dashboard');  
     }

    public function  hm_bankinfo_submit(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $whereHotel =array('hotel_id'=>$request->h);//  ,$request->field=>$request->val
            $hotel = HotelInfo::where($whereHotel)->first();

            if($hotel)
            {
                $bankInfo = HotelBankAcDetails::where('hotel_id','=',$request->h)->first();
                if($bankInfo)
                {
                    $bankInfo->account_num = $request->ac;
                    $bankInfo->bank_name = $request->bn;
                    $bankInfo->ac_holder_name = $request->achn;
                    $bankInfo->updated_by = auth()->user()->id;
                    $bankInfo->updated_at = Carbon::now();
                    $bankInfo->save();       
                }   
                else
                { 
                    $newInfo = HotelBankAcDetails::create([
                        'hotel_id' => $request->h,
                        'account_num'=>$request->ac,
                        'bank_name'=>$request->bn,
                        'ac_holder_name'=>$request->achn,
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);  
                } 

                if($hotel->bank_detail_status == 0)
                {
                    $hotel->bank_detail_status = 1;
                    $hotel->completed_percentage = $hotel->completed_percentage +15;
                    $hotel->save();
                }    

                if($request->savetype == 'save_n_exit' && $access =='admin')
                    $nextpageurl = route('hotel_managment');
                else if($request->savetype == 'save_n_exit' && $access =='hotel_manager')  
                    $nextpageurl = route('dashboard');
                else    
                    $nextpageurl = route('hm_summary', ['id' => $request->h]);
                
                $data = [
                    'status' => 1,
                    'nextpageurl' => $nextpageurl,
                    'message' => 'saved successfully.'
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
        else
        {
            $data = [
                'status' => 0,
                'message'=>'you are not authorized.'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
