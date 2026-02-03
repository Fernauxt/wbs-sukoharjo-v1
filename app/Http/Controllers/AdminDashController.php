<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class AdminDashController extends Controller
{
    //
    public function index()
    {
        $stats = [
            'totalReports' => Report::count(),
            'sentReports' => Report::whereHas('status', fn($q) => $q->where('name', 'Terkirim'))->count(),
            'inProgressReports' => Report::whereHas('status', fn($q) => $q->where('name', 'Diproses'))->count(),
            'needClarifyReports' => Report::whereHas('status', fn($q) => $q->where('name', 'Diverifikasi'))->count(),
            'completedReports' => Report::whereHas('status', fn($q) => $q->where('name', 'Selesai'))->count(),
            'rejectedReports' => Report::whereHas('status', fn($q) => $q->where('name', 'Ditolak'))->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
