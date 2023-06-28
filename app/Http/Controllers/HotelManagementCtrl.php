<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\HotelInfo;
use App\Models\HotelImages;
use App\Models\HotelFacilities;
use App\Models\HotelFeatures;
use App\Models\Facilities;
use App\Models\Features;
use App\Models\NearestTouristAttractions;
use App\Models\HotelExtraServices;
use App\Models\LongStayDiscount;
use App\Models\HotelPeakSeason;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class HotelManagementCtrl extends Controller
{

    public function index()
    {
        //
    }

    // upload hotel logo
    public function uploadHotelLogo(Request $request)
    {
        $whereHotel =array('hotel_id'=>$request->id);
        $hotel = HotelInfo::where($whereHotel)->first();
        if($hotel)
        {
            // $folderPath = public_path('hotel_logo/');
            $folderPath = 'hotel_logo/';
            $image_parts = explode(";base64,", $request->image);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $logo = uniqid() . '.png';
            $file = $folderPath . $logo;

            file_put_contents($file, $image_base64);
            $hotel->templogo = $logo;
            $hotel->save();
            return response()->json(['status'=>1,'message'=>'updated successfully','logo'=>$logo]);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }
    }

    // delete hotel logo
    public function delHotelLogo(Request $request)
    {
        $whereHotel =array('hotel_id'=>$request->id);
        $hotel = HotelInfo::where($whereHotel)->first();
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

    // delete hotel other image
    public function delHotelOtherImg(Request $request)
    {
        $whereImage =array('hotel_id'=>$request->h,'id'=>$request->i);
        $image = HotelImages::where($whereImage)->first();
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
    public function markFeaturedHotelImg(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $whereHotel =array('hotel_id'=>$request->h);
            $hotel = HotelInfo::where($whereHotel)->first();

            $whereImage =array('hotel_id'=>$request->h,'id'=>$request->i);
            $image = HotelImages::where($whereImage)->first();
            if($image)
            {
                // update multiple rows make all existing images non-featured
                $res = HotelImages::where("hotel_id", $request->h)->update(["is_featured" => "0"]);
                // make featured
                $image->is_featured = 1;
                $image->save();

                if($hotel)
                {
                    $hotel->featured_img = $image->image;
                    $hotel->save();
                }
                // $image->delete();
                return response()->json(['status'=>1,'message'=>'Marked as featured successfully']);
            }
            else
            {
                return response()->json(['status'=>0,'message'=>'Something went wrong']);
            }
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Not authorized.']);
        }
    }


    // upload hotel other iamges
    public function uploadHotelOtherImages(Request $request)
    {
        $access = auth()->user()->access;
        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $whereHotel =array('hotel_id'=>$request->h);
            $hotel = HotelInfo::where($whereHotel)->first();
            $HotelImages = HotelImages::where('hotel_id','=',$request->h)->where('status','!=','deleted')->count(); //->select(['count(id)'])->first();
            // dd($HotelImages);
            if($hotel)
            {
                // $folderPath = public_path('hotel_images/');
                $folderPath = 'hotel_images/';
                $image_parts = explode(";base64,", $request->image);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $img = uniqid() .uniqid() . '.png';
                $file = $folderPath . $img;

                file_put_contents($file, $image_base64);
                // $hotel->tempimg = $img;
                // $hotel->save();
                $is_featured = ($HotelImages == 0 )?1:0;
                $newImg= HotelImages::create([
                    'hotel_id' => $request->h,
                    'image' => $img,
                    'is_featured' => $is_featured,
                    'status' => 'active',
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $delurl = asset("/assets/images/").'/structure/delete-circle-red.svg';
                $imgurl = asset("/hotel_images/".$newImg->image);
                $is_featured_cls = ($is_featured==1)?"fa fa-star favStar favStar-fill":"fa fa-star-o favStar favStar-outline";
                $marktitle ="<div class='tooltipbox centerArrowTT'><small class='mediumfont'>Mark as Featured</small> </div>";
                $imgRes ='<div class="hotelImgaesPreviewCol" id="hotel_img_'.$newImg->id.'"><img src="'.$delurl.'" alt="" class="deteteImageIcon delHotelOtherImg" data-i="'.$newImg->id.'"><i class="markfeaturedhmimg '.$is_featured_cls.'" data-i="'.$newImg->id.'" aria-hidden="true" data-bs-toggle="tooltip" data-bs-html="true" title="'.$marktitle.'" id="featured_icon_'.$newImg->id.'"></i><img src="'.$imgurl.'" alt="N.A." class="hotelPreviewImgae"></div>';

                if($is_featured==1)
                {
                    $hotel->featured_img = $img;
                    $hotel->save();
                }

                return response()->json(['status'=>1,'message'=>'upload successfully','img'=>$imgRes]);
            }
            else
            {
                return response()->json(['status'=>0,'message'=>'Something went wrong']);
            }
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Not authorized.']);
        }
    }
    // close

    // delete Nearest-Tourist-Attractions
    public function delNTA(Request $request)
    {
        $whereNta =array('hotel_id'=>$request->h,'id'=>$request->i);
        $nta = NearestTouristAttractions::where($whereNta)->first();
        if($nta)
        {
            $nta->status = 'deleted';
            $nta->save();
            // $image->delete();
            return response()->json(['status'=>1,'message'=>'Deleted successfully']);
        }
        else
        {
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }
    }

    // delete extra service
    public function delES(Request $request)
    {
        // $request->ri means row id & $request->h means hotel_id
        $credentials =array('id'=>$request->i,'hotel_id'=>$request->h);
        $row = HotelExtraServices::where($credentials)->first();
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            if($row)
            {
                $row->updated_by = auth()->user()->id;
                $row->updated_at = Carbon::now();
                $row->status = 'deleted';
                $row->save();
                $data = [
                    'status' => 1,
                    'message' => 'Deleted successfully.'
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'You are not authorized.'
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'You are not authorized.'
            ];
            return response()->json($data);
        }
    }

    // delete long stay discount
    public function delLSD(Request $request)
    {
        // $request->ri means row id & $request->h means hotel_id
        $credentials =array('id'=>$request->i,'hotel_id'=>$request->h);
        $row = LongStayDiscount::where($credentials)->first();
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            if($row)
            {
                $row->updated_by = auth()->user()->id;
                $row->updated_at = Carbon::now();
                $row->status = 'deleted';
                $row->save();
                $data = [
                    'status' => 1,
                    'message' => 'Deleted successfully.'
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'You are not authorized.'
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'You are not authorized.'
            ];
            return response()->json($data);
        }
    }

    // delete hotel peak season
    public function delPS(Request $request)
    {
        // $request->ri means row id & $request->h means hotel_id
        $credentials =array('id'=>$request->i,'hotel_id'=>$request->h);
        $row = HotelPeakSeason::where($credentials)->first();
        if(auth()->user()->access =='admin' || auth()->user()->id == $request->h)
        {
            if($row)
            {
                $row->updated_by = auth()->user()->id;
                $row->updated_at = Carbon::now();
                $row->status = 'deleted';
                $row->save();
                $data = [
                    'status' => 1,
                    'message' => 'Deleted successfully.'
                ];
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'You are not authorized.'
                ];
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status' => 0,
                'message'=>'You are not authorized.'
            ];
            return response()->json($data);
        }
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id){ }
}
