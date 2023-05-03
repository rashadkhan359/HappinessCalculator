<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userWeeklyActivity(){
        return $this->hasMany(UserWeeklyActivity::class);
    }
    
    public function adminactivities($activity_id)
    {
        $name=Activity::where('id',$activity_id)->select('name')->first();
        return $name;
    }
    
}
