<?php

namespace App\Http\Controllers\UserPwa;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPwaDashboardController extends Controller
{
    /**
     * Display User PWA Dashboard with active/completed requests summary.
     */
    public function index()
    {
        $user = Auth::user();
        $mobile = $user ? $user->mobile_number : null;
        $userId = $user ? $user->id : null;

        $requests = WasteRequest::where(function($q) use ($mobile, $userId) {
            if ($mobile) {
                $q->where('mobile_number', $mobile);
            }
            if ($userId) {
                $q->orWhere('user_id', $userId);
            }
        })->latest()->get();

        $pendingRequests = $requests->whereIn('status', ['pending', 'assigned', 'before_pickup']);
        $completedRequests = $requests->whereIn('status', ['picked_up', 'dumped', 'completed']);

        return view('userpwa.dashboard', compact('requests', 'pendingRequests', 'completedRequests'));
    }
}
