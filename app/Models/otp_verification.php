<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otp_verification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'otp',
        'otp_verification_status',
        'otp_expire_time',
        'otp_type',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
