<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirQualityReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('air_quality_readings', function (Blueprint $table) {
            $table->id();
            $table->float('temperature')->nullable();  //: 25.4,           // in °C
            $table->float('humidity')->nullable();  //: 45.2,              // in %
            $table->float('co2')->nullable();  //: 400,                    // in ppm
            $table->float('pm1_0')->nullable();  //: 10.5,                 // in µg/m³
            $table->float('pm2_5')->nullable();  //: 15.3,                 // in µg/m³
            $table->float('pm4')->nullable();  //: 20.1,                   // in µg/m³
            $table->float('pm10')->nullable();  //: 30.2,                  // in µg/m³
            $table->float('eco2')->nullable();  //: 450,                   // in ppm
            $table->float('tvoc')->nullable();  //: 150                    // in ppb
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
        Schema::dropIfExists('air_quality_readings');
    }
}
