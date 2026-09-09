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

        $query = WasteRequest::with(['ward.constituency.corporation', 'vehicle']);

        if ($mobile || $userId) {
            $query->where(function($q) use ($mobile, $userId) {
                if ($mobile) {
                    $q->where('mobile_number', $mobile);
                }
                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            });
        }

        $requests = $query->latest()->get();

        // Dynamic user stats counts
        $totalRequests = $requests->count();
        $completedRequests = $requests->whereIn('status', ['picked_up', 'dumped', 'completed'])->count();
        $inProgressRequests = $requests->whereIn('status', ['assigned', 'before_pickup'])->count();
        $pendingRequests = $requests->where('status', 'pending')->count();

        // City-wide platform stats
        $platformTotal = WasteRequest::count();
        $platformCompleted = WasteRequest::whereIn('status', ['picked_up', 'dumped', 'completed'])->count();
        $platformInProgress = WasteRequest::whereIn('status', ['assigned', 'before_pickup'])->count();
        $platformPending = WasteRequest::where('status', 'pending')->count();

        $recentRequests = $requests->take(3);

        return view('userpwa.dashboard', compact(
            'requests',
            'totalRequests',
            'completedRequests',
            'inProgressRequests',
            'pendingRequests',
            'platformTotal',
            'platformCompleted',
            'platformInProgress',
            'platformPending',
            'recentRequests',
            'user'
        ));
    }
}
