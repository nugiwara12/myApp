<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clearance extends Model
{
    use HasFactory;

    protected $table = 'clearances';

    protected $fillable = [
        'full_name',
        'birthdate',
        'age',
        'gender',
        'civil_status',
        'citizenship',
        'occupation',
        'contact',
        'house_no',
        'purok',
        'barangay',
        'municipality',
        'province',
        'purpose',
    ];
}
