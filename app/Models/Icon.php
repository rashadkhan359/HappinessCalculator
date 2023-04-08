<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icon extends Model
{
    use HasFactory;

    public function icons()
    {
        return $this->hasMany(Activity::class, 'icon_id');
    }
}
