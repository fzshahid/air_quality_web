<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCcs811ReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ccs811_readings', function (Blueprint $table) {
            $table->id();
            $table->decimal('temperature')->nullable();
            $table->decimal('humidity')->nullable();
            $table->decimal('eco2')->nullable();
            $table->decimal('tvoc')->nullable();
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
        Schema::dropIfExists('ccs811_readings');
    }
}
