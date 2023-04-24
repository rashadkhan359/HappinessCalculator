<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWeeklyActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_weekly_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_activity_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('day_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->foreign('user_activity_id')->references('id')->on('user_activities')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_weekly_activities');
    }
}
