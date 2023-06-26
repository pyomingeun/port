<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RatingReview;
use App\Models\User;
use App\Models\HotelInfo;
use App\Models\Booking;
use Carbon\Carbon;
use Session;
use DB;

class RatingReviewCtrl extends Controller
{
    //Rating listing in admin // load view rating submit
    public function index(Request $request)
    {
        //
        $access = auth()->user()->access;
        $loggedId = auth()->user()->id;

        $query = RatingReview::join('user', 'user.id', '=', 'rating_reviews.created_by');
        $query->join('hotel_info', 'hotel_info.hotel_id', '=', 'rating_reviews.hotel_id');
        $query->where('rating_reviews.status', '=', 'active');
        // $query->where('rating_reviews.hotel_id', '=', $hotel->hotel_id);
        $query->select(['user.full_name','hotel_info.hotel_name', 'rating_reviews.*']);
        if($access !='admin')
            $query->where('rating_reviews.hotel_id', '=', $loggedId);

        // $query->select(['hotel_info.hotel_name','rating_reviews.*' ]);

        if($access =='admin' && isset($request->h) && $request->h !='')
        {
            $hotel = HotelInfo::where('status', '!=', 'deleted')->where('slug', '=', $request->h)->select('id','hotel_id','slug','hotel_name')->first();
            $query->where('rating_reviews.hotel_id', '=', $hotel->hotel_id);
            $h = $request->h; 
            $hname = $hotel->hotel_name;
        }
        else
            { $h = $loggedId; $hname =''; }
        
        if($request->q !='')
        {
            $keyword = $request->q;
            $query->whereNested(function($query) use ($keyword) {
                $query->where('user.full_name', 'LIKE', "%{$keyword}%");
                $query->orWhere('rating_reviews.review', 'LIKE', "%{$keyword}%");
                $query->orWhere('hotel_info.hotel_name', 'LIKE', "%{$keyword}%");
            });
        }        

        $query->get();

        $c = (isset($request->c) && $request->c !='')?$request->c:'rating_reviews.id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $dtype = (isset($request->dtype) && $request->dtype !='')?$request->dtype:'';
        $query->orderBy($c,$o);

        $ratingRevies = $query->paginate(10);

        if($access =='admin')
        {
            $hotels = HotelInfo::where('status', '!=', 'deleted')->select('id','hotel_id','slug','hotel_name')->get();  
            return view('admin.rating_review_list')->with(['hotels'=>$hotels,'ratingRevies'=>$ratingRevies,'o'=>$request->o,'c'=>$request->c,'h'=>$h,'dtype'=>$dtype,'hname'=>$hname]);        
        }
        else
        {
            return view('admin.rating_review_list')->with(['ratingRevies'=>$ratingRevies,'o'=>$request->o,'c'=>$request->c,'h'=>$h,'dtype'=>$dtype,'hname'=>$hname]);
        }
    }
    
    // load view rating submit
    public function saveRating($slug)
    {
        $access = auth()->user()->access;
        $loggedId = auth()->user()->id;
        
        $booking = Booking::where('status', '=', 'active')->where('slug', '=', $slug)->where('customer_id', '=', $loggedId)->where('is_rated', '=', 0)->where('booking_status', '=', 'completed')->select('id','slug','hotel_id','customer_id')->first();  
        if($booking)
        {
            // dd($booking->customer_id);
            $hotel = HotelInfo::where('hotel_id', '=', $booking->hotel_id)->select('*')->first();
            return view('customer.submit_rating_review')->with(['booking'=>$booking,'hotel'=>$hotel]);        
        }
        else
        {
            return redirect()->route('home');
        }
    }

    // Rating submit
    public function submitRating(Request $request)
    {
        $access = auth()->user()->access;
        $loggedId = auth()->user()->id;
        $booking = Booking::where('status', '=', 'active')->where('slug', '=', $request->b)->where('customer_id', '=', $loggedId)->where('is_rated', '=', 0)->where('booking_status', '=', 'completed')->select('id','slug','hotel_id','customer_id')->first();
        if($booking)
        {
            $hotel = HotelInfo::where('hotel_id', '=', $booking->hotel_id)->first();
        
            $avg_rating = round((($request->cleanliness + $request->facilities + $request->service +$request->value_for_money)/4),1);  
            $newRating= RatingReview::create([
                'hotel_id' => $booking->hotel_id,
                'booking_id' => $booking->id,
                'cleanliness'=>$request->cleanliness,
                'facilities'=>$request->facilities,
                'service'=>$request->service,
                'value_for_money'=>$request->value_for_money,
                'avg_rating'=>$avg_rating,
                'review'=>$request->review,
                'status'=>'active',
                'created_by'=>$loggedId,
                'updated_by'=>$loggedId,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),

            ]);
            
            if($newRating)
            {
                $booking->is_rated = 1;
                $booking->save();
                
                $hotelAvgRating = RatingReview::where('hotel_id', '=', $booking->hotel_id)->where('status', '=', 'active')->avg('avg_rating');

                $hotelReviews = RatingReview::where('hotel_id', '=', $booking->hotel_id)->where('status', '=', 'active')->count();
                
                $hotel->rating = round($hotelAvgRating,1);
                $hotel->reviews = $hotelReviews;
                $hotel->save();
                $data = [
                    'status' => 1,
                    'message' =>'Rating-Review saved successfully.'
                ];    
                return response()->json($data);
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message' =>'Somthing went wrong.'
                ];
                return response()->json($data);
            }                            
        }
        else
        {
            $data = [
                'status' => 0,
                'message' =>'Somthing went wrong.'
            ];
            return response()->json($data);   
        }        
        
    }

    // Delete Rating-Review 
    public function delete_ratingreview($id)
    {
        if(auth()->user()->access =='admin')
        {
            $row = RatingReview::where('id', '=', $id)->where('status', '!=', 'deleted')->first();
            if($row)
            {
                $row->status = 'deleted';
                $row->updated_by = auth()->user()->id;
                $row->updated_at = Carbon::now();
                $row->save();

                $hotel = HotelInfo::where('hotel_id', '=', $row->hotel_id)->where('status', '!=', 'deleted')->first();

                $hotelAvgRating = RatingReview::where('hotel_id', '=', $row->hotel_id)->where('status', '=', 'active')->avg('avg_rating');

                $hotelReviews = RatingReview::where('hotel_id', '=', $row->hotel_id)->where('status', '=', 'active')->count();
                
                $hotel->rating = round($hotelAvgRating,1);
                $hotel->reviews = $hotelReviews;
                $hotel->save();
                
                return redirect()->route('rating-review-list')->with('success_msg','Rating-Review deleted successfully.');
            }
            else
                return redirect()->route('rating-review-list')->with('error_msg','Invalid record');            
        }
        else
            return redirect()->route('rating-review-list')->with('error_msg','Not authorized');
    }

}
