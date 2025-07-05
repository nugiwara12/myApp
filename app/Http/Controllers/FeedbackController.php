<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index()
    {
        return view('admin.feedback');
    }

    public function getFeedback()
    {
        return response()->json(Feedback::latest()->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Log::info('Feedback request:', $request->all());

        Feedback::create([
            'name' => $request->name,
            'message' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted']);
    }

    public function bulkDelete(Request $request)
    {
        Feedback::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Bulk deleted']);
    }
}
