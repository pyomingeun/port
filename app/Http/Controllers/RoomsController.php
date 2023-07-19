<?php

namespace App\Http\Controllers;
// basic for all ctrl
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
//
use App\Models\Rooms;
use App\Models\RoomBeds;
use App\Models\RoomFacilities;
use App\Models\RoomFeatures;
use App\Models\RoomImages;
use App\Models\HotelFacilities;
use App\Models\HotelFeatures;
use App\Models\HotelPeakSeason;
use App\Models\Booking;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = auth()->user()->id;
        $query = Rooms::where('rooms.status', '!=', 'deleted')->where('rooms.hotel_id', '=', $hotel_id);
        // $query->where('rooms.status', '=', 'customer');
        $query->select(['*']);
        $query->get();

        if($request->q !='')
        {
            $query->where('rooms.room_name',  'like', '%' . $request->q . '%');
        }

        if($request->status !='')
        {
            $query->where('status', '=', $request->status);
        }

        $c = (isset($request->c) && $request->c !='')?$request->c:'id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $q = (isset($request->q) && $request->q !='')?$request->q:'';
        $status = (isset($request->status) && $request->status !='')?$request->status:'';
        // $dates = (isset($request->dates) && $request->dates !='')?$request->dates:'';
        $query->orderBy($c,$o);
        $rooms = $query->paginate(8);

        return view('hotel.rooms_list')->with(['rooms'=>$rooms,'o'=>$request->o,'c'=>$request->c,'q'=>$q,'status'=>$status]);
    }

    // Step 1 secton
    // Room basic info
    public function rm_basic_info($slug)
    {
        // $id = //base64_decode($id); //encrypt($id);
        $hotel_id = auth()->user()->id;
        $res = RoomImages::where("hotel_id", $hotel_id)->where("room_id", 0)->where("status", 'draft')->update(["status" => 'deleted']);
        $room = Rooms::with('hasImages')->where('slug', '=', $slug)->where('status', '!=', 'deleted')->where('status', '!=', 'deleted')->first();
        // dd($hotel);
        if($room)
        {
            return view('hotel.room_basic_info')->with(['room'=>$room,'slug'=>$room->slug]);
        }
        else
            return view('hotel.room_basic_info')->with(['slug'=>'new']);
    }

    // delete Room other image
    public function delRoomOtherImg(Request $request)
    {
        $whereImage =array('room_id'=>$request->r,'id'=>$request->i);
        $image = RoomImages::where($whereImage)->first();
        if($image)
        {
            if($image->is_featured ==0)
            {
                $image->status = 'deleted';
                $image->save();
                // $image->delete();
                return response()->json(['status'=>1,'message'=>'Deleted successfully']);
            }
            else
            {
                return response()->json(['status'=>0,'message'=>'Featured image can not delete.']);
            }

        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }
    }

    // mark as featured iamge
    public function markFeaturedRoomImg(Request $request)
    {
        $whereImage =array('room_id'=>$request->r,'id'=>$request->i);
        $image = RoomImages::where($whereImage)->first();
        if($image)
        {
            // update multiple rows make all existing images non-featured
            $res = RoomImages::where("room_id", $request->r)->update(["is_featured" => "0"]);
            // make featured
            $image->is_featured = 1;
            $image->save();
            // $image->delete();
            return response()->json(['status'=>1,'message'=>'Marked as featured successfully']);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }
    }


    // upload Room other iamges
    public function uploadRoomOtherImages(Request $request)
    {
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;
        $whereRoom =array('id'=>$request->r,'hotel_id'=>$hotel_id);
        $room = Rooms::where($whereRoom)->first();
        $RoomImages = RoomImages::where('room_id','=',$request->r)->where('hotel_id','=',$hotel_id)->where('status','!=','deleted')->count();

        // $folderPath = public_path('Room_images/');
        $folderPath = 'room_images/';
        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $img = uniqid() .uniqid() . '.png';
        $file = $folderPath . $img;

        file_put_contents($file, $image_base64);

        $is_featured = ($RoomImages == 0 )?1:0;
        $newImg= RoomImages::create([
            'room_id' => $request->r,
            'hotel_id' =>$hotel_id,
            'room_image' => $img,
            'is_featured' => $is_featured,
            'status' => 'draft',
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $delurl = asset("/assets/images/").'/structure/delete-circle-red.svg';
        $imgurl = asset("/room_images/".$newImg->room_image);
        $is_featured_cls = ($is_featured==1)?"fa fa-star favStar favStar-fill":"fa fa-star-o favStar favStar-outline";
        $marktitle ="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>Mark as Featured</small> </div>";
        $imgRes ='<div class="hotelImgaesPreviewCol" id="room_img_'.$newImg->id.'"><img src="'.$delurl.'" alt="" class="deteteImageIcon delRoomOtherImg" data-i="'.$newImg->id.'"><i class="markfeaturedhmimg '.$is_featured_cls.'" data-i="'.$newImg->id.'" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="'.$marktitle.'" id="featured_icon_'.$newImg->id.'"></i><img src="'.$imgurl.'" alt="N.A." class="hotelPreviewImage"></div>';
        return response()->json(['status'=>1,'message'=>'upload successfully','img'=>$imgRes]);
    }
    // close
    // close step-1 section

    // step-2 section open
    // Room beds info view
    public function rm_beds_info($slug)
    {
        // $id = //base64_decode($id); //encrypt($id);
        $room = Rooms::with('hasBeds')->where('slug', '=', $slug)->where('status', '!=', 'deleted')->first();
        // dd($hotel);
        if($room)
        {
            return view('hotel.room_beds_info')->with(['room'=>$room,'slug'=>$room->slug]);
        }
        else
            return view('hotel.room_beds_info')->with(['slug'=>'new']);
    }

    // Room beds info submit
    public function rm_basic_info_submit(Request $request)
    {
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;

        $room = Rooms::where('slug', '=', $request->slug)->where('hotel_id', '=', $hotel_id)->where('status', '!=', 'deleted')->first();

        if($room)
        {
            $room->room_name = $request->room_name;
            $room->room_size = $request->room_size;
            $room->room_description = $request->room_description;
            $room->basic_info_status = 1;

	        $room->no_of_bathrooms = $request->no_of_bathrooms;
            $room->beds_status = 1;

            $room->save();

            $counter = (isset($request->bed_type) && count($request->bed_type) >0)?count($request->bed_type):0;
            if($counter >0 )
            {
                for($i=0; $i<$counter; $i++)
                {
                    if($request->rid[$i] == 0)
                    {
                        if($request->bed_type[$i] !='' && $request->bed_qty[$i] >0)
                        {
                            $newBed = RoomBeds::create([
                                'hotel_id' => $hotel_id,
                                'room_id' => $room->id,
                                'no_of_bathrooms' => $request->no_of_bathrooms,
                                'bed_type' => $request->bed_type[$i],
                                'bed_qty' => $request->bed_qty[$i],
                                'status' =>'active',
                                'created_by' => $hotel_id,
                                'updated_by' => $hotel_id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                    }
                    else
                    {
                        if($request->bed_type[$i] !='' && $request->bed_qty[$i] >0)
                        {
                            $whereRow =array('hotel_id'=>$hotel_id,'room_id'=>$room->id,'id'=>$request->rid[$i]);
                            $row = RoomBeds::where($whereRow)->first();
                            if($row)
                            {
                                $row->updated_by = auth()->user()->id;
                                $row->updated_at = Carbon::now();
                                $row->bed_type  = $request->bed_type[$i];
                                $row->bed_qty = $request->bed_qty[$i];
                                $row->status = 'active';
                                $row->save();
                            }
                        }

                    }

                }
            }

            if($request->savetype == 'save_n_exit') //  && $access =='admin'
                $nextpageurl = route('rooms');
            else
                $nextpageurl = route('room_features_n_facilities', ['slug' => $room->slug]);

            $data = [
                'status'=>1,
                'message' => 'Saved successfully',
                'nextpageurl'=>$nextpageurl
            ];

            return response()->json($data);
        }
        else
        {
            $randomId  = rand(1000,9999);
            $timestamp = Carbon::now()->timestamp;
            $slug = $timestamp."".$randomId;

            $newRoom = Rooms::create([
                'room_name' => $request->room_name,
                'room_size' => $request->room_size,
                'room_description' => $request->room_description,
                'hotel_id'=> $hotel_id,
                'slug'=>$slug,
                'status'=>'draft',
                'created_by' => $hotel_id,
                'updated_by' => $hotel_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'no_of_bathrooms'=>$request->no_of_bathrooms,
                'beds_status'=>1
            ]);

            if($newRoom)
            {
                $counter = (isset($request->bed_type) && count($request->bed_type) >0)?count($request->bed_type):0;
                if($counter >0 )
                {
                    for($i=0; $i<$counter; $i++)
                    {

                        if($request->bed_type[$i] !='' && $request->bed_qty[$i] >0)
                        {
                            $newBed = RoomBeds::create([
                                'hotel_id' => $hotel_id,
                                'room_id' => $newRoom->id,
                                'bed_type' => $request->bed_type[$i],
                                'bed_qty' => $request->bed_qty[$i],
                                'status' =>'active',
                                'created_by' => $hotel_id,
                                'updated_by' => $hotel_id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }

                    }
                }
                if($request->savetype == 'save_n_exit') //  && $access =='admin'
                    $nextpageurl = route('rooms');
                else
                    $nextpageurl = route('room_features_n_facilities', ['slug' => $newRoom->slug]);

                $data = [
                    'status'=>1,
                    'message' => 'Saved successfully',
                    'nextpageurl'=>$nextpageurl
                ];

                return response()->json($data);
            }

            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'Something is wrong please try again.'
                ];
                return response()->json($data);
            }
        }
    }

    // delete Bed
    public function delBed(Request $request)
    {
        $hotel_id = auth()->user()->id;
        $whereBed =array('hotel_id'=>$hotel_id,'id'=>$request->i,'room_id'=>$request->r);
        $bed = RoomBeds::where($whereBed)->first();
        if($bed)
        {
            $bed->status = 'deleted';
            $bed->save();
            // $image->delete();
            return response()->json(['status'=>1,'message'=>'Deleted successfully']);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }
    }
    // step-2 section close

    // step-3 section open
    // Room beds info
    public function rm_features_n_facilities($slug)
    {
        // $id = //base64_decode($id); //encrypt($id);
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;
        $room = Rooms::where('slug', '=', $slug)->where('status', '!=', 'deleted')->first();
        // dd($hotel);
        $query = HotelFacilities::join('facilities', 'facilities.id', '=', 'hotel_facilities.facilities_id');
        $query->where('facilities.status', '!=', 'deleted');
        $query->where('hotel_facilities.status', '!=', 'deleted');
        $query->where('hotel_facilities.hotel_id', '=', $hotel_id);
        $query->select(['facilities.facilities_name', 'hotel_facilities.*']);
        $hotel_facilities = $query->get();

        $query2 = HotelFeatures::join('features', 'features.id', '=', 'hotel_features.features_id');
        $query2->where('features.status', '!=', 'deleted');
        $query2->where('hotel_features.status', '!=', 'deleted');
        $query2->where('hotel_features.hotel_id', '=', $hotel_id);
        $query2->select(['features.features_name', 'hotel_features.*']);
        $hotel_features = $query2->get();

        $features_ids = array();
        $facilities_ids = array();
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        if($room)
        {
            $selected_features_ids = DB::select("select GROUP_CONCAT(DISTINCT(features_id)) as ids from room_features WHERE room_id='".$room->id."' AND status !='deleted'");
            $selected_facilities_ids = DB::select("select GROUP_CONCAT(DISTINCT(facilities_id)) as ids from room_facilities WHERE room_id='".$room->id."' AND status !='deleted'");

            if($selected_features_ids !='' && $selected_features_ids !=null && $selected_features_ids !=false)
            {
                $features_ids = explode(",",$selected_features_ids[0]->ids);
            }
            if($selected_facilities_ids !='' && $selected_facilities_ids !=null && $selected_facilities_ids !=false)
            {
                $facilities_ids = explode(",",$selected_facilities_ids[0]->ids);
            }

            $query = RoomFacilities::join('facilities', 'facilities.id', '=', 'room_facilities.facilities_id');
            $query->where('facilities.status', '!=', 'deleted');
            $query->where('room_facilities.status', '!=', 'deleted');
            $query->where('room_facilities.hotel_id', '=', $hotel_id);
            $query->where('room_facilities.room_id', '=', $room->id);
            $query->select(['facilities.facilities_name', 'room_facilities.*']);
            $room_facilities = $query->get();

            $query2 = RoomFeatures::join('features', 'features.id', '=', 'room_features.features_id');
            $query2->where('features.status', '!=', 'deleted');
            $query2->where('room_features.status', '!=', 'deleted');
            $query2->where('room_features.hotel_id', '=', $hotel_id);
            $query2->where('room_features.room_id', '=', $room->id);
            $query2->select(['features.features_name', 'room_features.*']);
            $room_features = $query2->get();

            return view('hotel.room_feature_n_facilities')->with(['room'=>$room,'slug'=>$room->slug,'features_ids'=>$features_ids,'facilities_ids'=>$facilities_ids,'room_facilities'=>$room_facilities,'room_features'=>$room_features,'hotel_facilities'=>$hotel_facilities,'hotel_features'=>$hotel_features,'empty_val'=>'']);
        }
        else
            return view('hotel.room_feature_n_facilities')->with(['slug'=>'new','hotel_facilities'=>$hotel_facilities,'hotel_features'=>$hotel_features,'features_ids'=>$features_ids,'facilities_ids'=>$facilities_ids,'empty_val'=>'']);
    }

    // Room feature & facilities  submit
    public function rm_features_n_facilities_submit(Request $request)
    {
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;

        $room = Rooms::where('slug', '=', $request->slug)->where('hotel_id', '=', $hotel_id)->where('status', '!=', 'deleted')->first();

        if($room)
        {
            $room->roomfnf_status = 1;
            // if($room->basic_info_status == 1 && $room->beds_status  == 1  && $room->pricing_status  == 1)
            // {
            //     $room->status = 'active';
            // }

            $room->save();

            // delete and insert features
            $res = RoomFeatures::where("hotel_id", $hotel_id)->where("room_id", $room->id)->update(["status" => "deleted"]);

            $counter = (isset($request->features) && count($request->features) >0)?count($request->features):0;
            if($counter >0 )
            {
                for($i=0; $i<$counter; $i++)
                {
                    $whereRoomFeature =array('features_id'=>$request->features[$i],'room_id'=>$room->id);
                    $is_feature_exist = RoomFeatures::where($whereRoomFeature)->first();

                    if($is_feature_exist)
                    {
                        $is_feature_exist->status = 'active';
                        $is_feature_exist->save();
                    }
                    else
                    {
                        $newFeature = RoomFeatures::create([
                            'hotel_id' => $hotel_id,
                            'room_id' => $room->id,
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
            $res = RoomFacilities::where("hotel_id", $hotel_id)->where("room_id", $room->id)->update(["status" => "deleted"]);

            $counter = (isset($request->facilities) && count($request->facilities) >0)?count($request->facilities):0;
            if($counter >0 )
            {
                for($i=0; $i<$counter; $i++)
                {
                    $whereRoomFacilitie =array('facilities_id'=>$request->facilities[$i],'room_id'=>$room->id);
                    $is_facilitie_exist = RoomFacilities::where($whereRoomFacilitie)->first();

                    if($is_facilitie_exist)
                    {
                        $is_facilitie_exist->status = 'active';
                        $is_facilitie_exist->save();
                    }
                    else
                    {
                        $newFeature = RoomFacilities::create([
                            'hotel_id' => $hotel_id,
                            'room_id' => $room->id,
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

            if($request->savetype == 'save_n_exit') //  && $access =='admin'
                $nextpageurl = route('rooms');
            else
                $nextpageurl = route('room_occupancy_n_pricing', ['slug' => $room->slug]);

            $data = [
                'status'=>1,
                'message' => 'Saved successfully',
                'nextpageurl'=>$nextpageurl
            ];

            return response()->json($data);
        }
        else
        {
            $randomId  = rand(1000,9999);
            $timestamp = Carbon::now()->timestamp;
            $slug = $timestamp."".$randomId;

            $newRoom = Rooms::create([
                'room_name' => '',
                'room_size' => '',
                'room_description' => '',
                'hotel_id'=> $hotel_id,
                'slug'=>$slug,
                'status'=>'draft',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'roomfnf_status'=>1
            ]);

            if($newRoom)
            {
                if($request->savetype == 'save_n_exit') //  && $access =='admin'
                    $nextpageurl = route('rooms');
                else
                    $nextpageurl = route('room_occupancy_n_pricing', ['slug' => $newRoom->slug]);

                $data = [
                    'status'=>1,
                    'message' => 'Saved successfully',
                    'nextpageurl'=>$nextpageurl
                ];

                return response()->json($data);
            }
        }
    }
    // step-3 section close

     // step-4 section open
    // Room beds info
    public function rm_occupancy_n_pricing($slug)
    {
        // $id = //base64_decode($id); //encrypt($id);
        $hotel_id = (auth()->user()->access =='hotel_manager')?auth()->user()->id:auth()->user()->hotel_id;
        $room = Rooms::where('slug', '=', $slug)->where('status', '!=', 'deleted')->first();
        $season_names = HotelPeakSeason::where('hotel_id', '=', $hotel_id)->where('status', '=', 'active')->select('season_name')->get();
        $hotel_peak_season ='';
        $seaonCounter = count($season_names);
        if($seaonCounter >0 )
        {
            $hotel_peak_season = "<div class='tooltipbox'> <p class='mb-0'>";
            for($i=0; $i<$seaonCounter; $i++)
            {
                $comma = ($seaonCounter > 1  && $seaonCounter != ($i+1) )?',':'';
                $hotel_peak_season .="<span class='normalfont'>".$season_names[$i]->season_name."</span>".$comma."</p>";
            }
            $hotel_peak_season .="</div>";
        }


        if($room)
        {
            return view('hotel.room_occupancy_n_pricing')->with(['room'=>$room,'slug'=>$room->slug,'hotel_peak_season'=>$hotel_peak_season]);
        }
        else
            return view('hotel.room_occupancy_n_pricing')->with(['slug'=>'new','hotel_peak_season'=>$hotel_peak_season]);
    }

    // Room feature & facilities  submit
    public function rm_occupancy_n_pricing_submit(Request $request)
    {
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;

        $room = Rooms::where('slug', '=', $request->slug)->where('hotel_id', '=', $hotel_id)->where('status', '!=', 'deleted')->first();

        if($room)
        {
            $room->pricing_status = 1;
            $room->standard_occupancy_adult = $request->standard_occupancy_adult;
            $room->standard_occupancy_child = $request->standard_occupancy_child;
            $room->maximum_occupancy_adult = $request->maximum_occupancy_adult;
            $room->maximum_occupancy_child = $request->maximum_occupancy_child;
            $room->standard_price_weekday = $request->standard_price_weekday;
            $room->standard_price_weekend = $request->standard_price_weekend;
            $room->standard_price_peakseason = $request->standard_price_peakseason;
            $room->extra_guest_fee = $request->extra_guest_fee;
            if($room->basic_info_status == 1 && $room->beds_status  == 1  && $room->roomfnf_status  == 1)
            {
                 $room->status = 'active';
            }

            $room->save();

            if($request->savetype == 'save_n_exit') //  && $access =='admin'
                $nextpageurl = route('rooms');
            else
                $nextpageurl = route('room_summary', ['slug' => $room->slug]);

            $data = [
                'status'=>1,
                'message' => 'Saved successfully',
                'nextpageurl'=>$nextpageurl
            ];

            return response()->json($data);
        }
        else
        {
            $randomId  = rand(1000,9999);
            $timestamp = Carbon::now()->timestamp;
            $slug = $timestamp."".$randomId;

            $newRoom = Rooms::create([
                'room_name' => '',
                'room_size' => '',
                'room_description' => '',
                'hotel_id'=> $hotel_id,
                'slug'=>$slug,
                'status'=>'draft',
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'pricing_status'=>1
            ]);

            if($newRoom)
            {
                if($request->savetype == 'save_n_exit') //  && $access =='admin'
                    $nextpageurl = route('rooms');
                else
                    $nextpageurl = route('room_summary', ['slug' => $newRoom->slug]);

                $data = [
                    'status'=>1,
                    'message' => 'Saved successfully',
                    'nextpageurl'=>$nextpageurl
                ];

                return response()->json($data);
            }
        }
    }
    // step-4 section close

    // step-5 section open
    // Room summary view
    public function rm_summary($slug)
    {
        // $id = //base64_decode($id); //encrypt($id);
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;

        $room = Rooms::with('hasImages')->with('hasBeds')->where('slug', '=', $slug)->where('status', '!=', 'deleted')->first();
        // dd($hotel);
        if($room)
        {
            $query = RoomFacilities::join('facilities', 'facilities.id', '=', 'room_facilities.facilities_id');
            $query->where('facilities.status', '!=', 'deleted');
            $query->where('room_facilities.status', '!=', 'deleted');
            $query->where('room_facilities.hotel_id', '=', $hotel_id);
            $query->where('room_facilities.room_id', '=', $room->id);
            $query->select(['facilities.facilities_name', 'room_facilities.*']);
            $room_facilities = $query->get();

            $query2 = RoomFeatures::join('features', 'features.id', '=', 'room_features.features_id');
            $query2->where('features.status', '!=', 'deleted');
            $query2->where('room_features.status', '!=', 'deleted');
            $query2->where('room_features.hotel_id', '=', $hotel_id);
            $query2->where('room_features.room_id', '=', $room->id);
            $query2->select(['features.features_name', 'room_features.*']);
            $room_features = $query2->get();

            return view('hotel.room_summary')->with(['room'=>$room,'slug'=>$room->slug,'room_facilities'=>$room_facilities,'room_features'=>$room_features]);
        }
        else
           return redirect()->route('room_summary', ['slug' => $slug]);
    }

    // Room summary submit
    public function rm_summary_save(Request $request)
    {
        $access = auth()->user()->access;
        $hotel_id = auth()->user()->id;

        $room = Rooms::where('slug', '=', $request->slug)->where('hotel_id', '=', $hotel_id)->where('status', '!=', 'deleted')->first();

        if($room)
        {
            if($room->basic_info_status == 1 && $room->beds_status  == 1  && $room->roomfnf_status  == 1  && $room->pricing_status  == 1)
            {
                $room->status = 'active';
                $room->save();
                $data = [
                    'status'=>1,
                    'message' => 'Saved successfully'
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => 'Please complete all steps.'
                ];
                return response()->json($data);
            }


        }
        else
        {
            $data = [
                'status'=>0,
                'message' => 'Invalid room'
            ];
        }
    }
    // step-5 section close

    // update room status like delete
    public function room_status($slug,$status)
    {
        // dd($id,$status);
        $room = Rooms::where('slug', '=', $slug)->where('hotel_id', '=', auth()->user()->id)->where('status', '!=', 'deleted')->first();

        if($room)
        {
            if($status =='deleted')
            {
                $room->status = $status;
                $room->save();
                return redirect()->route('rooms')->with('success_msg','Room '.$status.' successfully');
            }
            elseif($status =='active' || $status =='inactive')
            {
                $status = ($status =='active')?'inactive':'active';
                $room->status = $status;
                $room->save();
                return redirect()->route('rooms')->with('success_msg','Room '.$status.' successfully');
            }
            else
            {
                return redirect()->route('rooms')->with('error_msg','Invalid status');
            }
        }
        else
            return redirect()->route('rooms')->with('error_msg','Invalid room');

    }

    // Room Calendar
     public function roomCalendar(Request $request)
     {
        if($request->session()->get('block_unblock_success_msg') !='')
        {
            $block_unblock_success_msg = $request->session()->get('block_unblock_success_msg');
            $request->session()->forget('block_unblock_success_msg');
        }
        else
            $block_unblock_success_msg = '';

        $hotel_id = auth()->user()->id;
        $query = Rooms::where('rooms.status', '=', 'active')->where('rooms.hotel_id', '=', $hotel_id);
        $query->select(['*']);
        $rooms = $query->get();
        $query->orderBy('id','asc');
        return view('hotel.room_calendar')->with(['rooms'=>$rooms,'block_unblock_success_msg'=>$block_unblock_success_msg]);
     }

     // Room Calendar
     public function getCalendarData(Request $request)
     {
        $hotel_id = auth()->user()->id;
        $query = Rooms::where('rooms.status', '=', 'active')->where('rooms.hotel_id', '=', $hotel_id);
        $query->select(['*']);
        $rooms = $query->get();
        $query->orderBy('id','asc');
        $startdateReq= date("Y-m-d", strtotime($request->startdate));
        $enddateReq= date("Y-m-d", strtotime($request->enddate));
        $startdate = Carbon::createFromFormat('Y-m-d', $startdateReq);
        $enddate = Carbon::createFromFormat('Y-m-d', $enddateReq);

        $period = CarbonPeriod::create($startdate, $enddate);
        // Iterate over the period
        // $i=1;
        $events = [];
        $counter =0;
        $no_of_rooms = count($rooms);
        foreach ($period as $date) {
            $theday =  $date->format('Y-m-d');
            for($i=0; $i<$no_of_rooms; $i++)
            {
                $roomStatus = checkRoomStatus($rooms[$i]->id, $theday);
                if($roomStatus)
                {
                    $url = route('booking-detail', ['slug' => $roomStatus[0]->slug]);
                    if($roomStatus[0]->booking_status == 'on_hold')
                        $color = '#D17D00';
                    else if($roomStatus[0]->booking_status == 'confirmed')
                        $color = '#00CC7A';
                    else if($roomStatus[0]->booking_status == 'completed')
                        $color = '#008952';
                    else if($roomStatus[0]->booking_status == 'blocked')
                    {
                        $color = '#B3261E';
                        $url = '';
                    }else
                        $color = '#D17D00';
                }
                else
                {
                    $url = route('create-booking');
                    $color = '#015AC3';
                }
                $price='₩ '.$rooms[$i]->standard_price_weekday;
                $arr = array('title'=>$rooms[$i]->room_name.'--'.$price,'start'=>$theday,'url'=>$url,'color'=>$color);
                $obj = (object) $arr;
                $events[$counter] = $obj;
                $counter++;
            }

        }
        // return $events;
        return response()->json($events);
        // echo "<pre>"; print_r($events);
     }

     public function roomBlockUnBlock(Request $request)
     {
        $hotel_id = auth()->user()->id;
        if(isset($request->room) && count($request->room) > 0)
        {
            if(isset($request->start_date) && isset($request->start_date) && $request->end_date !='' && $request->end_date !='')
            {
                if($request->start_date <= $request->end_date)
                {
                    if(isset($request->type) && $request->type !='')
                    {
                        if($request->type =='block')
                        {
                            for($i=0; $i<count($request->room); $i++)
                            {
                                $roomDetails = Rooms::where('slug', '=', $request->room[$i])->where('status', '!=', 'deleted')->first();
                                if($roomDetails)
                                {
                                    $isRoomBooked =  checkIsRoomBooked($roomDetails->id, $request->start_date, $request->end_date);

                                    if(count($isRoomBooked))
                                    {
                                        $data = [
                                            'status'=>0,
                                            'message' => 'The '.$roomDetails->room_name.' is already Blocked/Booked on given date preiod.'
                                        ];
                                        return response()->json($data);
                                    }
                                }
                                else
                                {
                                    $data = [
                                        'status'=>0,
                                        'message' => 'Invalid room please select room-again.'
                                    ];
                                    return response()->json($data);
                                }
                            }
                        }

                        $unblockCounter =0;
                        for($i=0; $i<count($request->room); $i++)
                        {
                            $roomInfo = Rooms::where('slug', '=', $request->room[$i])->where('status', '!=', 'deleted')->first();
                            if($roomInfo)
                            {
                                $startdateReq= date("Y-m-d", strtotime($request->start_date));
                                $enddateReq= date("Y-m-d", strtotime($request->end_date));
                                $startdate = Carbon::createFromFormat('Y-m-d', $startdateReq);
                                $enddate = Carbon::createFromFormat('Y-m-d', $enddateReq);

                                $period = CarbonPeriod::create($startdate, $enddate);
                                if($request->type =='block')
                                {

                                    /* $isRoomBooked =  checkIsRoomBooked($room->id, $request->start_date, $request->end_date);

                                    if(count($isRoomBooked))
                                    {
                                        $data = [
                                            'status'=>0,
                                            'message' => 'This room is already Blocked/Booked on given date preiod.'
                                        ];
                                        return response()->json($data);
                                    }
                                    else
                                    { */
                                        foreach ($period as $date) {
                                            $theday =  $date->format('Y-m-d');

                                            $randomId  = rand(1000,9999);
                                            $timestamp = Carbon::now()->timestamp;
                                            $slug = $timestamp."".$randomId;

                                            $newBlocked = Booking::create([
                                                'slug' => $slug,
                                                'hotel_id' => $hotel_id,
                                                'room_id' => $roomInfo->id,
                                                'customer_id' => 0,
                                                'check_in_date' => $theday,
                                                'check_out_date' => $theday,
                                                'customer_full_name' => '',
                                                'customer_phone' => '',
                                                'customer_email' => '',
                                                'customer_notes' => '',
                                                'no_of_adults' => 0,
                                                'no_of_childs' => 0,
                                                'childs_below_nyear' => 0,
                                                'childs_plus_nyear' => 0,
                                                'no_of_extra_guest' => 0,
                                                'no_of_nights' => 1,
                                                'child_ages' => '',
                                                'per_night_charges' => 0,
                                                'extra_guest_charges' => 0,
                                                'coupon_code' => '',
                                                'coupon_discount_amount' => 0,
                                                'long_stay_discount_amount' => 0,
                                                'reward_points_used' => 0,
                                                'payment_by_currency' => 0,
                                                'payment_by_points' => 0,
                                                'booking_status' => 'blocked',
                                                'payment_status' => 'waiting',
                                                'payment_method' => 'direct_bank_transfer',
                                                'cancellation_policy'=>'',
                                                'extra_services_charges'=>0,
                                                'total_price'=>0,
                                                'status'=>'active',
                                                'created_by' => 0,
                                                'updated_by' => 0,
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now()
                                            ]);
                                        }
                                        $data = [
                                            'status'=>1,
                                            'message' => 'Blocked successfully'
                                        ];
                                        $request->session()->put('block_unblock_success_msg', 'Blocked successfully');
                                        // return response()->json($data);
                                    // }

                                }
                                else if($request->type =='unblock')
                                {
                                    foreach ($period as $date) {
                                        $theday =  $date->format('Y-m-d');
                                        $blockedInfo = checkRoomBlocked($roomInfo->id, $theday);
                                        // var_dump($blockedInfo);
                                        if($blockedInfo)
                                        {
                                            $booking_id = $blockedInfo[0]->id;
                                            $booking = Booking::where('id', $booking_id)->where('booking_status', '=', 'blocked')->first();
                                            //var_dump($booking_id);
                                            if($booking){
                                                $booking->delete();
                                                $unblockCounter++;
                                            }
                                        }
                                    }

                                }
                                else
                                {
                                    $data = [
                                        'status'=>0,
                                        'message' => 'Invalid function type.'
                                    ];
                                    return response()->json($data);
                                }

                            }
                            else
                            {
                                $data = [
                                    'status'=>0,
                                    'message' => 'Invalid room please select room-again.'
                                ];
                                return response()->json($data);
                            }
                        }
                        // After loop finish
                        if($request->type =='unblock')
                        {
                            if($unblockCounter >0)
                            {
                                $data = [
                                    'status'=>1,
                                    'message' => 'Un-Blocked successfully'
                                ];
                                $request->session()->put('block_unblock_success_msg', 'Un-Blocked successfully');
                                // return response()->json($data);
                            }
                            else
                            {
                                $data = [
                                    'status'=>0,
                                    'message' => 'There is no blocked room on given date period.'
                                ];
                                // return response()->json($data);
                            }
                        }

                        return response()->json($data);
                    }
                    else
                    {
                        $data = [
                            'status'=>0,
                            'message' => 'Please select function block/unblock.'
                        ];
                        return response()->json($data);
                    }

                }
                else
                {
                    $data = [
                        'status'=>0,
                        'message' => 'Start date should be less than to end date.'
                    ];
                    return response()->json($data);
                }

            }
            else
            {
                $data = [
                    'status'=>0,
                    'message' => 'Please select date period.'
                ];
                return response()->json($data);
            }


        }
        else
        {
            $data = [
                'status'=>0,
                'message' => 'Please select room.'
            ];
            return response()->json($data);
        }



     }
}
