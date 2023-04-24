<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user_activity;

class UserWeeklyActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_activity_id',
        'user_id',
        'day_id',
        'start_time',
        'end_time',
    ];
    public function userActivity()
    {
        return $this->belongsTo(UserActivity::class);
    }

    public function userDailyActivity(){
        return $this->hasMany(UserDailyActivity::class);
    }
}
