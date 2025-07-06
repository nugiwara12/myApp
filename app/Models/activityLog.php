<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activityLog extends Model
{
   protected $fillable = [
        'user_id',
        'name',
        'email',
        'role',
        'description',
        'date_time',
    ];
}
