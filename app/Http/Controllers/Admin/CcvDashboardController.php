<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CcvObservation;
use App\Models\CcvAnswer;

class CcvDashboardController extends Controller
{
    public function index()
    {
        // Mengambil data laporan CCV
        $observations = CcvObservation::with('user')
            ->latest()
            ->paginate(10);

        // Total seluruh laporan
        $totalObservations = CcvObservation::count();

        // Total laporan hari ini
        $totalToday = CcvObservation::whereDate(
            'submitted_at',
            today()
        )->count();

        // Total laporan RC1
        $totalRC1 = CcvObservation::where(
            'risk_code',
            'RC1'
        )->count();

        // Total laporan RC3
        $totalRC3 = CcvObservation::where(
            'risk_code',
            'RC3'
        )->count();

        // Total jawaban Ya
        $totalYa = CcvAnswer::where(
            'answer',
            'ya'
        )->count();

        // Total jawaban Tidak
        $totalTidak = CcvAnswer::where(
            'answer',
            'tidak'
        )->count();

        return view('admin.ccv.index', compact(
            'observations',
            'totalObservations',
            'totalToday',
            'totalRC1',
            'totalRC3',
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