<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CcvObservation;
use App\Models\CcvAnswer;

class CcvDashboardController extends Controller
{
    public function index()
    {
        $observations = CcvObservation::with('user')
            ->latest()
            ->paginate(10);

        $totalObservations = CcvObservation::count();

        $totalToday = CcvObservation::whereDate(
            'submitted_at',
            today()
        )->count();

        $totalRC1 = CcvObservation::where('risk_code', 'RC1')->count();

        $totalYa = CcvAnswer::where('answer', 'ya')->count();

        $totalTidak = CcvAnswer::where('answer', 'tidak')->count();

        return view('admin.ccv.index', compact(
            'observations',
            'totalObservations',
            'totalToday',
            'totalRC1',
            'totalYa',
            'totalTidak'
        ));
    }

    public function show(CcvObservation $observation)
    {
        $observation->load([
            'user',
            'answers.evidences'
        ]);

        return view('admin.ccv.show', compact('observation'));
    }
}