<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\HotelInfo;
use App\Models\Booking;

class CouponCtrl extends Controller
{

    // coupon-listing
    public function index(Request $request)
    {
        $access = auth()->user()->access;
        $loggedId = auth()->user()->id;

        $query = Coupon::leftJoin('hotel_info', 'hotel_info.hotel_id', '=', 'coupons.hotel_id');
        $query->where('coupons.status', '!=', 'deleted');
        if($access !='admin')
            $query->where('coupons.hotel_id', '=', $loggedId);

        $query->select(['hotel_info.hotel_name','coupons.*' ]);
        // echo $request->h; die; 
        if($access =='admin' && isset($request->h) && $request->h !='' && $request->h !=0)
        {
            $hotel = HotelInfo::where('status', '!=', 'deleted')->where('slug', '=', $request->h)->select('id','hotel_id','slug','hotel_name')->first();
            $query->where('coupons.hotel_id', '=', $hotel->hotel_id);
            $h = $request->h; 
            $hname = $hotel->hotel_name;
        }
        else if(isset($request->h) && $request->h ==0)
            {   
                $h = $request->h; 
                $hname = 'For all hotel';
                $query->where('coupons.hotel_id', '=', 0);
            }
        else
            {   $h = $loggedId; $hname =''; }
        
        if(isset($request->dtype) && $request->dtype !='')
        {
            $query->where('coupons.discount_type', '=', $request->dtype);
        }

        $query->get();

        $c = (isset($request->c) && $request->c !='')?$request->c:'coupons.id';
        $o = (isset($request->o) && $request->o !='')?$request->o:'desc';
        $dtype = (isset($request->dtype) && $request->dtype !='')?$request->dtype:'';
        $query->orderBy($c,$o);

        $coupons = $query->paginate(10);

        if($access =='admin')
        {
            $hotels = HotelInfo::where('status', '!=', 'deleted')->select('id','hotel_id','slug','hotel_name')->get();  
            return view('hotel.coupon_list')->with(['hotels'=>$hotels,'coupons'=>$coupons,'o'=>$request->o,'c'=>$request->c,'h'=>$h,'dtype'=>$dtype,'hname'=>$hname]);        
        }
        else
        {
            return view('hotel.coupon_list')->with(['coupons'=>$coupons,'o'=>$request->o,'c'=>$request->c,'h'=>$h,'dtype'=>$dtype,'hname'=>$hname]);
        }
    }

    // load view of add/edit coupon
    public function input($slug)
    {
        $hotels = HotelInfo::where('status', '=', 'active')->select('id','hotel_id','slug','hotel_name')->get();  
     
        if($slug !='new')
        {
            $coupon = Coupon::where('status', '!=', 'deleted')->where('slug', '=', $slug)->select('*')->first();
            if($coupon)
            {
                $hotel = HotelInfo::where('hotel_id', '=', $coupon->hotel_id)->select('id','hotel_id','slug','hotel_name')->first();
                $hotel_name = ($hotel)?$hotel->hotel_name:'All'; 
                return view('hotel.coupon_code_input')->with(['coupon'=>$coupon,'hotels'=>$hotels,'slug'=>$slug,'hotel_name'=>$hotel_name]);
            }else
                return view('hotel.coupon_code_input')->with(['hotels'=>$hotels,'slug'=>'new']);    
        }
        else
            return view('hotel.coupon_code_input')->with(['hotels'=>$hotels,'slug'=>'new']);
    }    
    
    // create/edit coupon code 
    public function inputSubmit(Request $request)
    {
        $access = auth()->user()->access;
        $loggedId = auth()->user()->id;

        if(auth()->user()->access == 'admin' || (auth()->user()->id == $request->h))
        {
            $coupon_code_name =strtolower($request->coupon_code_name);
            $isCouponExist = Coupon::where('coupon_code_name', '=', $coupon_code_name)->where('hotel_id', '=', $request->h)->where('status', '!=', 'deleted')->where('slug', '!=', $request->slug)->count();
            if($isCouponExist == 0)
            {
                $coupon = Coupon::where('slug', '=', $request->slug)->where('hotel_id', '=', $request->h)->where('status', '!=', 'deleted')->first();
        
                if($coupon)
                {
                    $coupon->coupon_code_name = $coupon_code_name;
                    $coupon->discount_type = $request->discount_type;
                    $coupon->discount_amount = $request->discount_amount;
                    $coupon->max_discount_amount = $request->max_discount_amount;
                    $coupon->expiry_date = $request->expiry_date;
                    $coupon->limit_per_user = $request->limit_per_user;
                    $coupon->available_no_of_coupon_to_use = $request->available_no_of_coupon_to_use;
                    $coupon->updated_by = $loggedId;
                    $coupon->updated_at = Carbon::now();
                    
                    $coupon->save();
        
                    $data = [
                        'status'=>1,
                        'message' => 'Saved successfully'
                    ];
        
                    return response()->json($data);
                }
                else
                {
                    $randomId  = rand(1000,9999);
                    $timestamp = Carbon::now()->timestamp;
                    $slug = $timestamp."".$randomId;
                    
                    $newCoupon = Coupon::create([
                        'coupon_code_name' => $request->coupon_code_name,
                        'discount_type' => $request->discount_type,
                        'discount_amount' => $request->discount_amount,
                        'max_discount_amount' => $request->max_discount_amount,
                        'expiry_date' => $request->expiry_date,
                        'limit_per_user' => $request->limit_per_user,
                        'available_no_of_coupon_to_use' => $request->available_no_of_coupon_to_use,
                        'no_of_coupon_used' => 0,
                        'hotel_id'=> $request->h,
                        'slug'=>$slug,
                        'status'=>'active',
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    
                    if($newCoupon)
                    {
                    $data = [
                            'status'=>1,
                            'message' => 'Saved successfully'
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
            else
            {
                $data = [
                    'status' => 0,
                    'message'=>'Coupon is already exist.'
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

    // Delete coupon 
    public function delete_coupon($slug)
    {
        if(auth()->user()->access =='admin')
        $coupon = Coupon::where('slug', '=', $slug)->where('status', '!=', 'deleted')->first();
        else
        $coupon = Coupon::where('slug', '=', $slug)->where('hotel_id', '=', auth()->user()->id)->where('status', '!=', 'deleted')->first();

        if($coupon)
        {
            $coupon->status = 'deleted';
            $coupon->updated_by = auth()->user()->id;
            $coupon->updated_at = Carbon::now();
            $coupon->save();
            return redirect()->route('coupon-list')->with('success_msg','Coupon deleted successfully.');
        }
        else
            return redirect()->route('coupon-list')->with('error_msg','Invalid coupon');   
    }

    // Coupon Apply 
    public function applyCoupon(Request $request)
    {
        $coupon_code_name =strtolower($request->coupon_code);
        $today = date_format(Carbon::now(),"Y-m-d");
        $h = (isset($request->h))?$request->h:0;
        $isCouponExistSQL = Coupon::where('coupon_code_name', '=', $coupon_code_name);
            $isCouponExistSQL->whereNested(function($isCouponExistSQL) use ($h){
                $isCouponExistSQL->where('coupons.hotel_id', '=', $h);
                $isCouponExistSQL->orWhere('coupons.hotel_id', '=', 0);
            });
        // $isCouponExistSQL->where('hotel_id', '=', $request->h);
        $isCouponExistSQL->where('status', '=', 'active');
        $isCouponExistSQL->where('expiry_date', '>=', $today);
        $isCouponExist = $isCouponExistSQL->first(); 
        if($isCouponExist)
        {
            $checkNoOfCouponUsedSQL = "SELECT count(id) as no_of_used FROM `bookings` WHERE LOWER(coupon_code) ='$coupon_code_name' AND (hotel_id ='$h' OR hotel_id='0'); ";
            // echo $checkNoOfCouponUsedSQL."<br>";
            $no_of_bookings_where_coupon_used = DB::select($checkNoOfCouponUsedSQL);
            //dd($no_of_bookings_where_coupon_used[0]->no_of_used,$isCouponExist->available_no_of_coupon_to_use);
            if(($no_of_bookings_where_coupon_used[0]->no_of_used < $isCouponExist->available_no_of_coupon_to_use) || $isCouponExist->available_no_of_coupon_to_use ==0)
            {
                $cpnAmount = 0;
                $pbTotal = $request->grand_total;//  $request->roomStandardCharges + $request->ExtraGuestCharges; 
                $request->session()->put('coupon_code_name', $request->coupon_code);
                $request->session()->put('discount_amount', $isCouponExist->discount_amount);
                $request->session()->put('max_discount_amount', $isCouponExist->max_discount_amount);
                $request->session()->put('discount_type', $isCouponExist->discount_type);
                $request->session()->put('couponAppliedH', $request->h);
                // if($request->session()->get('discount_type')=='percentage')
                if($isCouponExist->discount_type=='percentage')
                {
                    $discountAmount = (float) $isCouponExist->discount_amount; //  (float) $request->session()->get('discount_amount');
                    $max_discount_amount =  (float) $isCouponExist->max_discount_amount; //  (float) $request->session()->get('max_discount_amount');
                    $cpnAmount = round(($pbTotal/100)*$discountAmount);
                    if($max_discount_amount < $cpnAmount)
                        $cpnAmount = $max_discount_amount;
                }
                else
                {
                   $cpnAmount = (float) $isCouponExist->discount_amount; // $request->session()->get('discount_amount');
                }
    
                if($cpnAmount)    
                    $grand_total = $request->grand_total - $cpnAmount;
                if($grand_total <0)
                {
                    $request->session()->put('applied_discount_amount', $grand_total);
                    $grand_total = 0;
                }                
                else
                {
                    $request->session()->put('applied_discount_amount', $cpnAmount);
                }
    
                $data = [
                    'status' => 1,
                    'message' => 'Coupon code applied successfully.'.$no_of_bookings_where_coupon_used[0]->no_of_used,
                    'coupon_code' => $request->coupon_code,
                    'cpnAmount' => $cpnAmount,
                    'grand_total' => $grand_total 
                ];    
                return response()->json($data);                
            }
            else
            {
                $data = [
                    'status' => 0,
                    'message' => 'This coupon limit exceeded.'
                ];    
                return response()->json($data);
            }

        }
        else
        {
            $data = [
                'status' => 0,
                'message' => 'Invalid coupon code.'
            ];    
            return response()->json($data);
        }            
    }
    // ______________________________________    

    public function removeCoupon(Request $request)
    {
        $coupon_code_name = strtolower($request->session()->get('coupon_code_name'));
        $isCouponExist = Coupon::where('coupon_code_name', '=', $coupon_code_name)->where('status', '=', 'active')->first();
        if($isCouponExist)
        {
            $cpnAmount = 0;
            $pbTotal = $request->roomStandardCharges + $request->ExtraGuestCharges; 

            /* if($request->session()->get('discount_type')=='percentage')
            {
                $discountAmount =  (float) $request->session()->get('discount_amount');
                $max_discount_amount =  (float) $request->session()->get('max_discount_amount');
                $cpnAmount = round(($pbTotal/100)*$discountAmount,2);
                if($max_discount_amount > $cpnAmount)
                    $cpnAmount = $max_discount_amount;
            }
            else
            {
               $cpnAmount = (float) $request->session()->get('discount_amount');
            }*/ 
            
            $applied_discount_amount =  (float) $request->session()->get('applied_discount_amount');

            
            $grand_total = $request->grand_total; //  + $applied_discount_amount;
            if($grand_total <0)
                $grand_total = 0;
               
            $request->session()->forget('coupon_code_name');
            $request->session()->forget('discount_amount');
            $request->session()->forget('max_discount_amount');
            $request->session()->forget('discount_type');
            $request->session()->forget('couponAppliedH');
            $request->session()->forget('applied_discount_amount');
            $data = [
                'status' => 1,
                'message' => 'Coupon code removed successfully.',
                'coupon_code' => '',
                'cpnAmount' => 0,
                'grand_total' => $grand_total 
            ];    
            return response()->json($data);
        }
        else
        {
            $data = [
                'status' => 0,
                'message' => 'Invalid coupon code.'.$coupon_code_name 
            ];    
            return response()->json($data);
        }

    }

}
