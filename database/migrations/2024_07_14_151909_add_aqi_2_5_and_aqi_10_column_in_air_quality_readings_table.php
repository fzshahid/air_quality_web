<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAqi25AndAqi10ColumnInAirQualityReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('air_quality_readings', function (Blueprint $table) {
            $table->unsignedSmallInteger('aqi_pm2_5')->nullable();
            $table->unsignedSmallInteger('aqi_pm10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('air_quality_readings', function (Blueprint $table) {
            $table->dropColumn(['aqi_pm2_5', 'aqi_pm10']);
        });
    }
}
