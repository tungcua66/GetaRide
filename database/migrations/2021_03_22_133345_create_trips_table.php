<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->integer('id')->unique()->autoIncrement();
            $table->integer('id_driver');
            $table->foreign('id_driver')->references('id')->on('users');
            $table->integer('number_of_seats');
            $table->text('starting_town');
            $table->text('ending_town');
            $table->timestamp('date_trip');
            $table->text('precision')->nullable();
            $table->float('price');
            $table->boolean('private')->default(false);
            $table->text('description')->nullable();
            $table->integer('id_group')->nullable();
            $table->foreign('id_group')->references('id')->on('groups');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
