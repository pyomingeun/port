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
        // create admin_global_variables table 
        Schema::create('admin_global_variables', function (Blueprint $table) {

            $table->id();
            $table->string('type')->default('');
            $table->string('value_for')->default('');
            $table->double('value', 10, 2)->default(0);  
            $table->enum('value_type', array('flat','percentage'))->default('percentage');
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
        //
    }
};
