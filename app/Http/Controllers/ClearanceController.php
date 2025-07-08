<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clearance;
use Barryvdh\DomPDF\Facade\Pdf;


class ClearanceController extends Controller
{
    public function index() {
        return view('clearance.index');
    }

    public function getIndClearance(Request $request)
    {
        $status = $request->input('status');
        $perPage = $request->input('per_page', 10); // Default to 10 entries per page

        $query = Clearance::query()->orderByDesc('created_at');

        if ($status !== null) {
            $query->where('status', $status);
        }

        $paginated = $query->paginate($perPage);

        return response()->json($paginated); // returns: data, current_page, last_page, etc.
    }

    public function addClearance(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name'     => 'required|string|max:255',
                'birthdate'     => 'required|date',
                'age'           => 'required|numeric|max:150',
                'gender'        => 'required|in:Male,Female',
                'civil_status'  => 'nullable|string|max:50',
                'citizenship'   => 'nullable|string|max:100',
                'occupation'    => 'nullable|string|max:100',
                'contact'       => 'nullable|string|max:50',
                'house_no'      => 'nullable|string|max:100',
                'purok'         => 'nullable|string|max:100',
                'barangay'      => 'required|string|max:100',
                'municipality'  => 'required|string|max:100',
                'province'      => 'required|string|max:100',
                'purpose'       => 'required|string|max:500',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

        $application = Clearance::create($validated);

        return response()->json([
            'message' => 'Barangay Clearance Application submitted successfully.',
            'data' => $application,
        ], 201);
    }

    public function updateClearance(Request $request, $id)
    {
        $clearance = Clearance::find($id);

        if (!$clearance) {
            return response()->json(['message' => 'Clearance not found.'], 404);
        }

        try {
            $validated = $request->validate([
                'full_name'     => 'nullable|string|max:255',
                'birthdate'     => 'nullable|date',
                'age'           => 'nullable|numeric|max:150',
                'gender'        => 'nullable|in:Male,Female',
                'civil_status'  => 'nullable|string|max:50',
                'citizenship'   => 'nullable|string|max:100',
                'occupation'    => 'nullable|string|max:100',
                'contact'       => 'nullable|string|max:50',
                'house_no'      => 'nullable|string|max:100',
                'purok'         => 'nullable|string|max:100',
                'barangay'      => 'nullable|string|max:100',
                'municipality'  => 'nullable|string|max:100',
                'province'      => 'nullable|string|max:100',
                'purpose'       => 'nullable|string|max:500',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

        // Auto-approval if age is between 1 and 20
        if (isset($validated['age']) && $validated['age'] >= 1 && $validated['age'] <= 20) {
            if (!empty($validated['purpose']) && !str_contains($validated['purpose'], 'APPROVAL ACCEPT')) {
                $validated['purpose'] = rtrim($validated['purpose']) . ' - APPROVAL ACCEPT';
            }
        }

        $clearance->update($validated);

        return response()->json([
            'message' => 'Clearance record updated successfully.',
            'data' => $clearance,
        ]);
    }

    public function showIndigencyPdf($id)
    {
        $indigency = Indigency::find($id);

        if (!$indigency) {
            abort(404, 'Indigency record not found.');
        }

        // Check age to determine which PDF layout to use
        $view = ($indigency->age >= 1 && $indigency->age <= 17)
            ? 'indigency.indigencyPdf'
            : 'indigency.legalPdf';

        $pdf = Pdf::loadView($view, compact('indigency'));

        return $pdf->stream("indigency_certificate_{$id}.pdf");
    }

    public function approveIndigency($id)
    {
        $indigency = Indigency::find($id);

        if (!$indigency) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        if ($indigency->age >= 1 && $indigency->age <= 20) {
            if (!str_contains($indigency->purpose, 'APPROVAL ACCEPT')) {
                $indigency->purpose = rtrim($indigency->purpose) . ' - APPROVAL ACCEPT';
                $indigency->save();
            }

            return response()->json([
                'message' => 'Approved successfully.',
                'data' => $indigency
            ]);
        }

        return response()->json(['message' => 'Age not within approval range.'], 400);
    }

    public function delete($id)
    {
        Indigency::where('id', $id)->update(['status' => 0]);
        return response()->json(['message' => 'Record soft deleted.']);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        Indigency::whereIn('id', $ids)->update(['status' => 0]);
        return response()->json(['message' => 'Selected records marked as deleted.']);
    }

    public function restore(Request $request)
    {
        $ids = $request->input('ids', []);
        Indigency::whereIn('id', $ids)->update(['status' => 1]);

        return response()->json(['message' => 'Records restored.']);
    }
}
