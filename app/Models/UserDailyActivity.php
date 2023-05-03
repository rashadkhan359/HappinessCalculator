<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_weekly_activity_id',
        'user_id',
        'status',
        'start_time',
        'end_time',
        'score'
    ];
    
    public function userWeeklyActivity()
    {
        return $this->belongsTo(UserWeeklyActivity::class);
    }

    
}
