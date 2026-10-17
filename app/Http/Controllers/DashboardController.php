<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Library;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            $stats = [
                'total_libraries' => Library::count(),
                'active_libraries' => Library::where('status', 'active')->count(),
                'total_branches' => Branch::count(),
                'total_users' => User::count(),
            ];
            $libraries = Library::withCount('branches')->latest()->take(5)->get();

            return view('dashboard.superadmin', compact('stats', 'libraries'));
        }

        $library = $user->library;

        if (!$library) {
            abort(403, 'User is not assigned to any library tenant.');
        }

        $branchIds = $library->branches()->pluck('id');

        // 1. Student Metrics
        $totalStudents = Student::where('library_id', $library->id)->count();
        $activeStudents = Student::where('library_id', $library->id)->where('status', 'active')->count();
        $newStudentsThisMonth = Student::where('library_id', $library->id)
            ->where('joined_at', '>=', now()->startOfMonth())
            ->count();

        // 2. Seat & Live Occupancy Metrics
        $totalSeats = Seat::whereIn('branch_id', $branchIds)->count();
        $occupiedSeats = Seat::whereIn('branch_id', $branchIds)->where('status', 'occupied')->count();
        $availableSeats = Seat::whereIn('branch_id', $branchIds)->where('status', 'available')->count();
        $occupancyRate = $totalSeats > 0 ? round(($occupiedSeats / $totalSeats) * 100, 1) : 0;

        // 3. Live Attendance Today
        $currentlyPresent = Attendance::where('library_id', $library->id)
            ->where('status', 'present')
            ->count();
        $todayCheckIns = Attendance::where('library_id', $library->id)
            ->whereDate('check_in_at', today())
            ->count();
        $recentAttendances = Attendance::with(['student', 'branch'])
            ->where('library_id', $library->id)
            ->latest('check_in_at')
            ->take(6)
            ->get();

        // 4. Financial & Fee Metrics
        $monthlyRevenue = (float) Payment::where('library_id', $library->id)
            ->where('payment_date', '>=', now()->startOfMonth())
            ->sum('amount');
        $totalPendingDues = (float) Invoice::where('library_id', $library->id)
            ->where('status', '!=', 'cancelled')
            ->sum('balance_amount');
        $overdueInvoices = Invoice::with(['student'])
            ->where('library_id', $library->id)
            ->where('balance_amount', '>', 0)
            ->where('due_date', '<', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('due_date')
            ->take(5)
            ->get();
        $overdueInvoicesCount = Invoice::where('library_id', $library->id)
            ->where('balance_amount', '>', 0)
            ->where('due_date', '<', today())
            ->where('status', '!=', 'cancelled')
            ->count();

        $recentPayments = Payment::with(['student', 'invoice'])
            ->where('library_id', $library->id)
            ->latest('payment_date')
            ->take(5)
            ->get();

        // 5. Memberships Watchlist
        $activeMembershipsCount = Membership::where('library_id', $library->id)
            ->where('status', 'active')
            ->where('end_date', '>=', today())
            ->count();
        $expiringMemberships = Membership::with(['student', 'plan'])
            ->where('library_id', $library->id)
            ->where('status', 'active')
            ->whereBetween('end_date', [today(), today()->addDays(7)])
            ->orderBy('end_date')
            ->take(5)
            ->get();

        // 6. Branches with Seat and Active Member counts
        $branches = $library->branches()
            ->withCount([
                'seats',
                'memberships' => fn($q) => $q->where('status', 'active')->where('end_date', '>=', today())
            ])
            ->latest()
            ->get();

        $stats = [
            'total_students' => $totalStudents,
            'active_students' => $activeStudents,
            'new_students_month' => $newStudentsThisMonth,
            'total_seats' => $totalSeats,
            'occupied_seats' => $occupiedSeats,
            'available_seats' => $availableSeats,
            'occupancy_rate' => $occupancyRate,
            'currently_present' => $currentlyPresent,
            'today_checkins' => $todayCheckIns,
            'monthly_revenue' => $monthlyRevenue,
            'pending_dues' => $totalPendingDues,
            'overdue_count' => $overdueInvoicesCount,
            'active_memberships' => $activeMembershipsCount,
            'total_branches' => $branches->count(),
            'active_branches' => $branches->where('status', 'active')->count(),
            'total_staff' => User::where('library_id', $library->id)->count(),
        ];

        return view('dashboard', compact(
            'library',
            'stats',
            'branches',
            'recentAttendances',
            'recentPayments',
            'expiringMemberships',
            'overdueInvoices'
        ));
    }
}
