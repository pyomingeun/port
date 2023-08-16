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
        Schema::dropIfExists('admin_global_variables');
        // create admin_global_variables table 
        Schema::create('admin_global_variables', function (Blueprint $table) {

            $table->id();
            $table->string('type')->default('');
            $table->string('value_for')->default('');
            $table->double('value', 10, 2)->default(0);  
            $table->enum('value_type', array('flat','percentage'))->default('percentage');
            $table->enum('status', array('active','inactive','deleted'))->default('active');
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
