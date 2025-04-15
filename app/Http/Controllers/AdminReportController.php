<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Status;

class AdminReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $statuses = Status::all(); // Assuming you have a Status model
        $query = Report::query();

        // Apply filter if 'status' is provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status_id', $request->status);
        }

        $reports = $query->with(['informant', 'category', 'status'])->get();

        return view('admin.reports.index', compact('reports', 'statuses'));
    }


    public function show($id){
        // Ambil laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Kembalikan view dengan data laporan
        return view('admin.reports.show', compact('report'));
    }
    
    
}
