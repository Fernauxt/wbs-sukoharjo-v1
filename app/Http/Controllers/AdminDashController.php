<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Mpdels\Status;

class AdminDashController extends Controller
{
    //
    public function index()
    {
        $totalReports = Report::count();
        $sentReports = Report::where('status_id', 1)->count();
        $inProgressReports = Report::where('status_id', 2)->count();
        $needClarifyReports = Report::where('status_id', 3)->count();
        $completedReports = Report::where('status_id', 4)->count();

        return view('admin.dashboard', compact(
            'totalReports',
            'sentReports',
            'inProgressReports',
            'needClarifyReports',
            'completedReports'
        ));
    }
}
