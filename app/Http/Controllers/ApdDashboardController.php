<?php

namespace App\Http\Controllers;

use App\Models\ApdInspection;
use App\Models\ApdItem;
use App\Models\Worker;

class ApdDashboardController extends Controller
{
    /**
     * Dashboard khusus Admin.
     */
    public function admin()
    {
        $stats = [
            'apd_items' => ApdItem::count(),
            'workers' => Worker::count(),
            'total' => ApdInspection::count(),
            'lengkap' => ApdInspection::where('status', 'lengkap')->count(),
            'tidak_lengkap' => ApdInspection::where('status', 'tidak_lengkap')->count(),
        ];

        $inspections = ApdInspection::with(['worker', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'inspections'));
    }

    /**
     * Dashboard khusus Pekerja Lapangan.
     */
    public function pekerja()
    {
        $userId = auth()->id();

        $query = ApdInspection::where('user_id', $userId);

        $stats = [
            'total' => (clone $query)->count(),
            'lengkap' => (clone $query)->where('status', 'lengkap')->count(),
            'tidak_lengkap' => (clone $query)->where('status', 'tidak_lengkap')->count(),
        ];

        $inspections = ApdInspection::with('worker')
            ->where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get();

        return view('pekerja.dashboard', compact('stats', 'inspections'));
    }
}
