<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indigency extends Model
{
    protected $table = 'indigencies';

    // Allow mass assignment on these fields
    protected $fillable = [
        'parent_name',
        'address',
        'purpose',
        'childs_name',
        'age',
        'status',
        'date',
    ];

    // Optional: Type casting
    protected $casts = [
        'date' => 'date',
        'status' => 'integer',
        'age' => 'integer',
    ];
}
