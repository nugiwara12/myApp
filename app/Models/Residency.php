<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residency extends Model
{
    use HasFactory;

    protected $table = 'residencies'; // Change if your table name is different

    protected $fillable = [
        'resident_name',
        'resident_age',
        'civil_status',
        'nationality',
        'address',
        'has_criminal_record',
        'resident_purpose',
        'certificate_number',
        'status',
        'resident_email_address',
        'voters_id_pre_number',
        'issue_date',
        'zip_code',
        'approved_by',
        'approved',
        'barangay_name',
        'municipality',
        'province',
    ];

    protected $casts = [
        'has_criminal_record' => 'boolean',
        'status' => 'integer',
        'approved' => 'integer',
    ];
}
