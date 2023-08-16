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
        Schema::dropIfExists('additional_discounts');
        Schema::create('additional_discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id')->default(0);
            $table->double('amount', 10, 2)->default(0);  
            $table->enum('amount_type', array('flat','percentage'))->default('flat');  
            $table->double('effective_amount', 10, 2)->default(0);
            $table->text('reason');
            $table->enum('status', array('active','inactive','deleted'))->default('active');
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
        Schema::dropIfExists('additional_discounts');
    }
};
