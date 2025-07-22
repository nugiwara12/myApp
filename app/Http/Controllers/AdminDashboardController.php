<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Feedback;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch data from the database
        $users = User::all();
        $logs = ActivityLog::latest()->limit(10)->get();
        $feedbacks = Feedback::latest()->limit(5)->get();

        // Return the view with data
        return view('admin.dashboard', compact('users', 'logs', 'feedbacks'));
    }
}
