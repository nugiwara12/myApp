<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Residency;
use App\Mail\ResidenceSubmitted;
use App\Mail\ResidenceApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf; // Add this at the top if not already

class ResidencyController extends Controller
{
    public function index() {
        return view('residence.index');
    }

    public function approvedFIle(Request $request, $id)
    {
        $residence = Residency::findOrFail($id);
        $user = auth()->user();

        $role = $user->getRoleNames()->first() ?? 'Admin'; // Use Spatie properly
        $approver = "{$user->name} ({$role})";

        $residence->approved_by = $approver;
        $residence->save();

        try {
            Mail::to($residence->resident_email_address)->send(new ResidenceApproved($residence));
        } catch (\Exception $e) {
            \Log::error('Approval email failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Residence approved successfully.',
            'residence' => $residence
        ]);
    }

    public function addResidence(Request $request)
    {
        try {
            $validated = $request->validate([
                'resident_name' => 'required|string|max:255',
                'resident_email_address' => 'required|email|max:255|unique:residencies,resident_email_address',
                'voters_id_pre_number' => 'required|regex:/^[A-Za-z0-9]+$/|max:255',
                'resident_age' => 'required|integer|max:150',
                'civil_status' => 'required|string',
                'nationality' => 'required|string',
                'address' => 'required|string',
                'zip_code' => 'required|string|max:20',
                'has_criminal_record' => 'boolean',
                'resident_purpose' => 'required|string',
                'certificate_number' => 'required|string|unique:residencies,certificate_number',
                'issue_date' => 'required|date',
                'barangay_name' => 'required|string',
                'municipality' => 'required|string',
                'province' => 'required|string',
                'voters_id_pre_number' => 'required|string|max:255',
            ]);

            // Force approved_by = 0 (not approved yet)
            $validated['approved_by'] = 0;

            $residency = Residency::create($validated);

            try {
                Mail::to($residency->resident_email_address)->send(new ResidenceSubmitted($residency));
            } catch (\Exception $e) {
                Log::error('Failed to send residence email: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'Residency added successfully.',
                'data' => $residency
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding residency.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getResidenceInformation(Request $request, $id = null)
    {
        if ($id) {
            // Return single residency by ID
            $residency = Residency::findOrFail($id);
            return response()->json($residency);
        }

        // Return paginated residency list
        $residencies = Residency::latest()->paginate(10);
        return response()->json($residencies);
    }

    public function updateResidence(Request $request, $id)
    {
        try {
            $residency = Residency::findOrFail($id);

            $validated = $request->validate([
                'resident_name' => 'nullable|string|max:255',
                'resident_email_address' => 'nullable|email|max:255|unique:residencies,resident_email_address,' . $residency->id,
                'voters_id_pre_number' => 'nullable|regex:/^[A-Za-z0-9]+$/|max:255',
                'resident_age' => 'nullable|integer|max:150',
                'civil_status' => 'nullable|string',
                'nationality' => 'nullable|string',
                'address' => 'nullable|string',
                'zip_code' => 'nullable|string|max:20',
                'has_criminal_record' => 'boolean',
                'resident_purpose' => 'nullable|string',
                'certificate_number' => 'nullable|string',
                'issue_date' => 'nullable|date',
                'barangay_name' => 'nullable|string',
                'municipality' => 'nullable|string',
                'province' => 'nullable|string',
            ]);

            $residency->update($validated);

            return response()->json([
                'message' => 'Residency updated successfully.',
                'data' => $residency
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Residency not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating residency.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function residencePdf($id)
    {
        $residence = Residency::find($id);

        if (!$residence) {
            abort(404, 'Residency record not found.');
        }

        // Use minor or legal PDF based on age
        $view = ($residence->resident_age >= 1 && $residence->resident_age <= 17)
            ? 'residence.minorResidencePdf'     // Minor PDF
            : 'residence.legalPdf';        // Legal age PDF

        $pdf = Pdf::loadView($view, compact('residence'));

        return $pdf->stream("residence_certificate_{$id}.pdf");
    }

    public function approveResidence($id)
    {
        $residency = Residency::find($id);

        if (!$residency) {
            return response()->json(['message' => 'Residency record not found.'], 404);
        }

        if ($residency->resident_age >= 1 && $residency->resident_age <= 17) {
            $residency->approved = 1;
            $residency->save();

            return response()->json([
                'message' => 'Approved successfully.',
                'data' => $residency
            ]);
        }

        return response()->json(['message' => 'Age not within approval range.'], 400);
    }

    public function delete($id)
    {
        Residency::where('id', $id)->update(['status' => 0]);
        return response()->json(['message' => 'Record soft deleted.']);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Residency::whereIn('id', $ids)->update(['status' => 0]);
        return response()->json(['message' => 'Selected records marked as deleted.']);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids', []);
        Residency::whereIn('id', $ids)->update(['status' => 1]);

        return response()->json(['message' => 'Records restored.']);
    }
}
