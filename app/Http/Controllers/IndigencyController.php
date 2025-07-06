<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Indigency;

class IndigencyController extends Controller
{
    public function index() {
        return view('indigency.index');
    }

    public function addIndigency(Request $request) {
        // Validate request
        $validated = $request->validate([
            'parent_name'   => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'purpose'       => 'required|string|max:255',
            'childs_name'   => 'required|string|max:255',
            'age'           => 'required|integer|min:0|max:150',
            'date'          => 'required|date',
        ]);

        // Explicitly set status to 1 (active)
        $validated['status'] = 1;

        // Create record
        $indigency = Indigency::create($validated);

        // Return JSON response
        return response()->json([
            'message' => 'Indigency record added successfully.',
            'data' => $indigency
        ], 201); // 201 Created
    }

    public function updateIndigency(Request $request, $id)
    {
        $validated = $request->validate([
            'parent_name' => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'purpose'     => 'nullable|string|max:255',
            'childs_name' => 'nullable|string|max:255',
            'age'         => 'nullable|integer|min:1|max:150',
            'date'        => 'nullable|date',
        ]);

        $indigency = Indigency::find($id);
        if (!$indigency) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        $indigency->update($validated);

        return response()->json([
            'message' => 'Indigency record updated successfully.',
            'data' => $indigency,
        ]);
    }

    public function getIndigencies(Request $request)
    {
        $status = $request->input('status');

        $query = Indigency::query();

        if ($status !== null) {
            $query->where('status', $status); // filter by status
        }

        $indigencies = $query->orderByDesc('created_at')->get();

        return response()->json([
            'data' => $indigencies
        ]);
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
