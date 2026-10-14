<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Services\AttendanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KioskController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService)
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();

        $branches = $user->isSuperAdmin()
            ? Branch::all()
            : Branch::where('library_id', $user->library_id)->get();

        $defaultBranch = $branches->first();

        return view('kiosk.index', compact('branches', 'defaultBranch'));
    }

    public function scan(Request $request): JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $token = $request->input('token');
        $branchId = (int) $request->input('branch_id');

        $result = $this->attendanceService->processScan($token, $branchId);

        return response()->json($result);
    }
}
