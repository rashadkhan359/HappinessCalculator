<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDailyActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_daily_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_weekly_activity_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('status')->default(0);
            $table->time('start_time');
            $table->time('end_time');
            $table->tinyInteger('score')->default(0);       
            $table->foreign('user_weekly_activity_id')->references('id')->on('user_weekly_activities')->onDelete('cascade');
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
        Schema::dropIfExists('user_daily_activities');
    }
}
