<?php

namespace App\Http\Controllers;

// basic for all ctrl
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
// 
use App\Models\MyFavorite;
use App\Models\HotelInfo;
use App\Models\HotelFacilities;
use App\Models\HotelFeatures;

class MyFavoriteCtrl extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $loggedid = auth()->user()->id;
        //  $myFavorites = MyFavorite::where('status', '=', 'marked')->where('created_by', '=', $loggedid)->get();

        $query = MyFavorite::join('hotel_info', 'hotel_info.hotel_id', '=', 'my_favorites.hotel_id');
        $query->where('hotel_info.status', '=', 'active');
        $query->where('my_favorites.status', '=', 'marked');
        $query->where('my_favorites.created_by', '=', $loggedid);
        $query->select(['hotel_info.hotel_name','hotel_info.featured_img','hotel_info.slug','hotel_info.street','hotel_info.city','hotel_info.pincode','hotel_info.subrub','hotel_info.rating','hotel_info.reviews', 'my_favorites.*']);
        $hoteles = $query->get();
        // $hoteles = $query->toSql();

        for($i=0; $i<count($hoteles); $i++)
        {
            $query = HotelFacilities::join('facilities', 'facilities.id', '=', 'hotel_facilities.facilities_id');
            $query->where('facilities.status', '!=', 'deleted');
            $query->where('hotel_facilities.status', '!=', 'deleted');
            $query->where('hotel_facilities.hotel_id', '=', $hoteles[$i]->hotel_id);
            $query->select(['facilities.facility_name', 'hotel_facilities.*']);
            $hoteles[$i]->facilities = $query->get();
    
            $query2 = HotelFeatures::join('features', 'features.id', '=', 'hotel_features.features_id');
            $query2->where('features.status', '!=', 'deleted');
            $query2->where('hotel_features.status', '!=', 'deleted');
            $query2->where('hotel_features.hotel_id', '=', $hoteles[$i]->hotel_id);
            $query2->select(['features.feature_name', 'hotel_features.*']);
            $hoteles[$i]->features = $query2->get();
        } 
        // dd($hoteles);
        return view('customer.my_favorites')->with(['hoteles'=>$hoteles]); //, compact('user')
    }


    // my favorite mark/unmark toggle 
    public function myFavoriteToggle(Request $request)
    {
        $access = auth()->user()->access;
        $loggedid = auth()->user()->id;
        $hotel_id  = $request->h;
        $isMyFavorite = MyFavorite::where('hotel_id', '=', $hotel_id)->where('created_by', '=', $loggedid)->first();
        
        if($access =='customer')
        {
            if($isMyFavorite)
            {
                $message ='';
                $markstatus='';
                if($isMyFavorite->status =='unmark')
                {
                    $message = 'Saved successfully in your favorite list.';
                    $isMyFavorite->status = 'marked';    
                    $markstatus = 'marked';
                }
                else
                {
                    $message = 'Removed successfully from your favorite list.';
                    $isMyFavorite->status = 'unmark';
                    $markstatus='unmark';
                }
    
                $isMyFavorite->created_by = $loggedid;
                $isMyFavorite->updated_at = Carbon::now();
                $isMyFavorite->save();
    
                $data = [
                    'status'=>1,
                    'message' => $message,
                    'markstatus'=>$markstatus
                ];
    
                return response()->json($data);
            }
            else
            {
                $newMyFavorite = MyFavorite::create([
                    'hotel_id'=> $hotel_id,
                    'status'=>'marked',
                    'created_by' => $loggedid,
                    'updated_by' => $loggedid,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
    
                $data = [
                    'status'=>1,
                    'message' => 'Saved successfully in your favorite list.',
                    'markstatus'=>'marked'
                ];
    
                return response()->json($data);
            }
        }
        else
        {
            $data = [
                'status'=>0,
                'message' => 'You are not authorized.'
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
        $hotel_id = auth()->user()->id;

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
