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
        // Hotel Long Stay Discount
        Schema::dropIfExists('long_stay_discount');
        Schema::create('long_stay_discount', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->default(0);
            $table->integer('lsd_min_days')->default(0);
            $table->integer('lsd_max_days')->default(0); 
            $table->double('lsd_discount_amount', 10, 2)->default(0);
            $table->enum('lsd_discount_type', array('flat','percentage'))->default('percentage');
            $table->enum('status', array('draft','active','inactive', 'deleted'))->default('draft');
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
