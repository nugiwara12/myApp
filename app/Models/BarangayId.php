<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayId extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangayId_image',
        'barangayId_email',
        'barangayId_full_name',
        'barangayId_address',
        'barangayId_birthdate',
        'barangayId_place_of_birth',
        'barangayId_age',
        'barangayId_citizenship',
        'barangayId_gender',
        'barangayId_civil_status',
        'barangayId_contact_no',
        'barangayId_guardian',
        'barangayId_generated_number',
        'approved_by',
        'status',
        'approved',
    ];
}
