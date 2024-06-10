<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSps30ReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sps30_readings', function (Blueprint $table) {
            $table->id();
            $table->float('pm1_0')->nullable();  //: 10.5,                 // in µg/m³
            $table->float('pm2_5')->nullable();  //: 15.3,                 // in µg/m³
            $table->float('pm4')->nullable();  //: 20.1,                   // in µg/m³
            $table->float('pm10')->nullable();  //: 30.2,
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
        Schema::dropIfExists('sps30_readings');
    }
}
