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
        // Admin Features
        Schema::dropIfExists('features');
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name', 250);
            $table->string('feature_icon')->default('');
            $table->timestamps(false);
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
