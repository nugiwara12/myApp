<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indigency;
use Barryvdh\DomPDF\Facade\Pdf; // Add this at the top if not already

class IndigencyController extends Controller
{
    public function index() {
        return view('indigency.index');
    }

    public function addIndigency(Request $request) {
        $validated = $request->validate([
            'parent_name'   => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'purpose'       => 'required|string|max:255',
            'childs_name'   => 'required|string|max:255',
            'age'           => 'required|integer|min:0|max:150',
            'date'          => 'required|date',
        ]);

        // Leave as-is: don't append "APPROVAL ACCEPT"
        $validated['status'] = 1;

        $indigency = Indigency::create($validated);

        return response()->json([
            'message' => 'Indigency record added successfully.',
            'data' => $indigency
        ], 201);
    }

    public function updateIndigency(Request $request, $id)
    {
        $indigency = Indigency::find($id);

        if (!$indigency) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        // ✅ Manual approval request
        if ($request->has('approve') && $indigency->age >= 1 && $indigency->age <= 17) {

            return response()->json([
                'message' => 'Approved successfully.',
                'data' => $indigency
            ]);
        }

        // ✅ Normal update
        $validated = $request->validate([
            'parent_name' => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'purpose'     => 'nullable|string|max:255',
            'childs_name' => 'nullable|string|max:255',
            'age'         => 'nullable|integer|min:1|max:150',
            'date'        => 'nullable|date',
        ]);


        $indigency->update($validated);

        return response()->json([
            'message' => 'Indigency record updated successfully.',
            'data' => $indigency,
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

        if ($indigency->age >= 1 && $indigency->age <= 17) {
            $indigency->approved = 1;
            $indigency->save();

            return response()->json([
                'message' => 'Approved successfully.',
                'data' => $indigency
            ]);
        }

        return response()->json(['message' => 'Age not within approval range.'], 400);
    }

    public function getIndigencies(Request $request)
    {
        $status = $request->input('status');
        $perPage = $request->input('per_page', 10); // Default to 10 entries per page

        $query = Indigency::query()->orderByDesc('created_at');

        if ($status !== null) {
            $query->where('status', $status);
        }

        $paginated = $query->paginate($perPage);

        return response()->json($paginated); // returns: data, current_page, last_page, etc.
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
