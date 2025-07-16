<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indigency;
use App\Models\Residency;
use App\Models\BarangayId;

class BarangayServiceController extends Controller
{
    public function trackRequest($trackingNumber)
    {
        // Check Barangay ID
        $barangayId = BarangayId::where('barangayId_generated_number', $trackingNumber)->first();
        if ($barangayId) {
            return response()->json([
                'name' => $barangayId->barangayId_full_name,
                'service_type' => 'Barangay ID',
                'approved_by' => $barangayId->approved_by ?? 'N/A',
                'created_at' => $barangayId->created_at,
                'status' => $barangayId->status,
            ]);
        }

        // Check Residency
        $residency = Residency::where('certificate_number', $trackingNumber)->first();
        if ($residency) {
            return response()->json([
                'name' => $residency->resident_name,
                'service_type' => 'Residency Certificate',
                'approved_by' => $residency->approved_by ?? 'N/A',
                'created_at' => $residency->created_at,
                'status' => $residency->status,
            ]);
        }

        // Check Indigency
        $indigency = Indigency::where('indigency_generated_number', $trackingNumber)->first();
        if ($indigency) {
            return response()->json([
                'name' => $indigency->resident_name,
                'service_type' => 'Certificate of Indigency',
                'approved_by' => $indigency->approved_by ?? 'N/A',
                'created_at' => $indigency->created_at,
                'status' => $indigency->status,
            ]);
        }

        // No match found
        return response()->json(['message' => 'No result found.'], 404);
    }
}
