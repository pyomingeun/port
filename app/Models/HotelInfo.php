<?php

namespace App\Models;
use App\Models\HotelImages;
use App\Models\NearestTouristAttractions;
use App\Models\CancellationCharges;
use App\Models\HotelFeatures;
use App\Models\HotelFacilities;
use App\Models\HotelExtraServices;
use App\Models\LongStayDiscount;
use App\Models\HotelPeakSeason;
use App\Models\HotelBankAcDetails;
use App\Models\MyFavorite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelInfo extends Model
{
    use HasFactory;
    protected $table = 'hotel_info';
    
    protected $fillable = [
        'slug', 'hotel_id', 'hotel_name', 'logo', 'featured_img', 'description', 'latitude', 'longitude', 'formatted_address', 'administrative_leve_1', 'locality', 'sublocality', 'route', 'street', 'check_in', 'check_out', 'hotel_policy', 'terms_and_conditions','same_day_refund', 'b4_1day_refund', 'b4_2days_refund', 'b4_3days_refund', 'b4_4days_refund', 'b4_5days_refund', 'b4_6days_refund', 'b4_7days_refund', 'b4_8days_refund', 'b4_9days_refund', 'b4_10days_refund', 'rating', 'bank_detail_status','basic_info_status','address_status','hpolicies_status','fnf_status','other_info_status','summary_status','completed_percentage', 'created_by', 'updated_by', 'created_at', 'updated_at','is_editors_pick','min_advance_reservation','max_advance_reservation','total_payble_payout' 	 
    ];

    function hotel_user() { return $this->belongsTo(User::class, "hotel_id", "id"); }

    public function hasImage() {   return $this->hasMany(HotelImages::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('hotel_images.id', 'desc'); }
    public function hasImageActive() {   return $this->hasMany(HotelImages::class, "hotel_id",  "hotel_id")->where('status','=','active')->orderBy('hotel_images.id', 'desc'); }
    
    public function hasFeaturedImage() {
        return $this->hasOne(HotelImages::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')
            ->orderBy('hotel_images.is_featured', 'desc')->latest();
    }

    public function hasAttractions() {   return $this->hasMany(NearestTouristAttractions::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('nearest_tourist_attractions.id', 'desc'); }

    public function hasExtraServices() {   return $this->hasMany(HotelExtraServices::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('hotel_extra_services.id', 'desc'); }

    public function hasLongStayDiscount() {   return $this->hasMany(LongStayDiscount::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('long_stay_discount.id', 'desc'); }

    public function hasPeakSeasont()    {   return $this->hasMany(HotelPeakSeason::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('hotel_peak_season.id', 'desc'); }

    public function hasCancellationCharges()    {   return $this->hasOne(CancellationCharges::class, "hotel_id",  "hotel_id"); }

    public function hasFeatures()    {   return $this->hasMany(HotelFeatures::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('hotel_features.id', 'desc'); }
    
    public function hasFacilities()    {   return $this->hasMany(HotelFacilities::class, "hotel_id",  "hotel_id")->where('status','!=','deleted')->orderBy('hotel_facilities.id', 'desc'); }

    public function hasHotelBankAcDetails()    {   return $this->hasOne(HotelBankAcDetails::class, "hotel_id",  "hotel_id"); }

    public function hasActiveRooms() {
        return $this->hasone(Rooms::class, "hotel_id",  "hotel_id")->where('status','active');
    }

    public function hasMarkedHotel() {
        return $this->hasMany(MyFavorite::class, "hotel_id",  "hotel_id")->where('status','marked');
    }

}
