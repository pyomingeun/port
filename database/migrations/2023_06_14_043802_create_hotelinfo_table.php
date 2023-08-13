<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('hotel_info');
        Schema::create('hotel_info', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->default('');
            $table->integer('hotel_id')->default(0);
            $table->string('logo', 100)->default('');;
            $table->string('hotel_name', 50);
            $table->string('areacode', 5)->default('');
            $table->string('phone')->default('');
            $table->string('featured_img', 100)->default('');
            $table->text('description')->nullable();
            $table->string('latitude', 15)->default('');
            $table->string('longitude', 15)->default('');
            $table->string('formatted_address', 100)->default('');
            $table->string('sido', 15)->default('');            
            $table->string('sigungu', 15)->default('');
            $table->string('check_in', 12)->default('');
            $table->string('check_out', 12)->default('');
            $table->text('hotel_policy')->nullable();
            $table->integer('b4_10day_refund')->default(0);
            $table->integer('b4_9day_refund')->default(0);
            $table->integer('b4_8day_refund')->default(0);
            $table->integer('b4_7day_refund')->default(0);
            $table->integer('b4_6day_refund')->default(0);
            $table->integer('b4_5day_refund')->default(0);
            $table->integer('b4_4day_refund')->default(0);
            $table->integer('b4_3day_refund')->default(0);
            $table->integer('b4_2day_refund')->default(0);
            $table->integer('b4_1day_refund')->default(0);
            $table->integer('b4_0day_refund')->default(0);
            $table->text('terms_and_conditions')->nullable();
            $table->integer('rating')->default(0);
            $table->integer('reviews')->default(0);
            $table->tinyInteger('bank_detail_status')->default(0);
            $table->tinyInteger('basic_info_status')->default(0);
            $table->tinyInteger('address_status')->default(0);
            $table->tinyInteger('hpolicies_status')->default(0);
            $table->tinyInteger('fnf_status')->default(0);
            $table->tinyInteger('other_info_status')->default(0);
            $table->tinyInteger('summary_status')->default(0);
            $table->tinyInteger('completed_percentage')->default(0);
            $table->enum('editors_pick', array('no','yes'))->default('no');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->default(0);
            $table->integer('min_advance_reservation')->default(0);
            $table->integer('max_advance_reservation')->default(0);
            $table->string('templogo')->default('');
            $table->enum('status', array('active','inactive', 'deleted'))->default('inactive');
            $table->integer('total_payble_payout')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotel_info', function (Blueprint $table) {
            //
        });
    }
};
