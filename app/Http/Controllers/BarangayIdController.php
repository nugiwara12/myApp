<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\BarangayId;
use App\Mail\BarangayIdConfirmationMail;
use App\Mail\BarangayIdApproved;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BarangayIdController extends Controller
{
    public function main() {
        return view('barangayId.index');
    }

    public function addBarangayId(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'barangayId_full_name' => 'required|string|max:255',
                'barangayId_email' => 'required|email|unique:barangay_ids',
                'barangayId_address' => 'required|string|max:255',
                'barangayId_birthdate' => 'required|date',
                'barangayId_place_of_birth' => 'required|string|max:255',
                'barangayId_age' => 'required|integer',
                'barangayId_citizenship' => 'required|string|max:255',
                'barangayId_gender' => 'required|in:male,female,other',
                'barangayId_civil_status' => 'required|string|max:255',
                'barangayId_contact_no' => 'required|regex:/^[0-9]{11}$/',
                'barangayId_guardian' => 'nullable|string|max:255',
                'barangayId_generated_number' => 'required|string|unique:barangay_ids',
                'barangayId_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            // ✅ Handle image upload with unique filename
            if ($request->hasFile('barangayId_image')) {
                $image = $request->file('barangayId_image');
                $extension = $image->getClientOriginalExtension();
                $filename = Str::uuid() . '.' . $extension; // Generates unique filename
                $image->move(public_path('barangayId'), $filename);
                $validated['barangayId_image'] = $filename;
            }

            // Save to database
            $barangayId = BarangayId::create($validated);

            // Send confirmation email
            Mail::to($barangayId->barangayId_email)->send(
                new BarangayIdConfirmationMail($barangayId->toArray())
            );

            return response()->json([
                'message' => 'Barangay ID submitted successfully.',
                'data' => $barangayId
            ], 200);

        } catch (\Exception $e) {
            Log::error('Barangay ID store error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Server error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateBarangayId(Request $request, $id)
    {
        try {
            $barangayId = BarangayId::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'barangayId_full_name' => 'nullable|string|max:255',
                'barangayId_email' => 'nullable|email|unique:barangay_ids,barangayId_email,' . $barangayId->id,
                'barangayId_address' => 'nullable|string|max:255',
                'barangayId_birthdate' => 'nullable|date',
                'barangayId_place_of_birth' => 'nullable|string|max:255',
                'barangayId_age' => 'nullable|integer',
                'barangayId_citizenship' => 'nullable|string|max:255',
                'barangayId_gender' => 'nullable|in:male,female,other',
                'barangayId_civil_status' => 'nullable|string|max:255',
                'barangayId_contact_no' => 'nullable|regex:/^[0-9]{11}$/',
                'barangayId_guardian' => 'nullable|string|max:255',
                'barangayId_generated_number' => 'nullable|string|unique:barangay_ids,barangayId_generated_number,' . $barangayId->id,
                'barangayId_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            // Handle image update only if a new file is uploaded
            if ($request->hasFile('barangayId_image')) {
                // Delete old image if it exists
                if ($barangayId->barangayId_image && file_exists(public_path('barangayId/' . $barangayId->barangayId_image))) {
                    unlink(public_path('barangayId/' . $barangayId->barangayId_image));
                }

                // Upload new image
                $image = $request->file('barangayId_image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('barangayId'), $filename);
                $validated['barangayId_image'] = $filename;
            }

            // Update other fields
            $barangayId->update($validated);

            return response()->json([
                'message' => 'Barangay ID updated successfully.',
                'data' => $barangayId
            ], 200);

        } catch (\Exception $e) {
            Log::error('Barangay ID update error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Server error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getBarangayIdList(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $barangayIds = BarangayId::orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($barangayIds);
    }

    public function getBarangayIdInformation($id)
    {
        $barangayId = BarangayId::findOrFail($id);
        return response()->json($barangayId);
    }

    public function approvedBarangayId(Request $request, $id)
    {
        $barangayIds = BarangayId::findOrFail($id);
        $user = auth()->user();

        $role = $user->getRoleNames()->first() ?? 'Admin';
        $approver = "{$user->name} ({$role})";

        $barangayIds->approved_by = $approver;
        $barangayIds->approved = 1;
        $barangayIds->save();

        try {
            Mail::to($barangayIds->barangayId_email)->send(new BarangayIdApproved($barangayIds->toArray()));
        } catch (\Exception $e) {
            \Log::error('Approval email failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Barangay ID approved successfully.',
            'barangayId' => $barangayIds
        ]);
    }

    public function barangayPdf($id)
    {
        $barangayIds = BarangayId::find($id);

        if (!$barangayIds) {
            abort(404, 'Barangay ID record not found.');
        }

        // Only allow minors (age <= 17)
        if ($barangayIds->resident_age > 17) {
            abort(404, 'Only minors are allowed for this certificate.');
        }

        // Load the PDF view
        $pdf = \PDF::loadView('barangayId.barangayId', compact('barangayIds'));

        return $pdf->stream("barangayId_certificate_{$id}.pdf");
    }

    public function delete($id)
    {
        BarangayId::where('id', $id)->update(['status' => 0]);
        return response()->json(['message' => 'Record soft deleted.']);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        BarangayId::whereIn('id', $ids)->update(['status' => 0]);
        return response()->json(['message' => 'Selected records marked as deleted.']);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids', []);
        BarangayId::whereIn('id', $ids)->update(['status' => 1]);

        return response()->json(['message' => 'Records restored.']);
    }
}
