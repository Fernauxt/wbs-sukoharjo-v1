<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCategory;
use App\Models\Status;
use App\Models\Informant;
use App\Models\Report;
use App\Models\ReportedPerson;
use App\Models\ReportedParty;

class ReportController extends Controller
{
    public function create()
    {
        return view('pages.create-report', [
            'categories' => ReportCategory::all(),
            'statuses' => Status::all(),
            'informants' => Informant::all()
        ]);
    }

    public function store(Request $request)
    {
        dd($request->all());
        // Validasi input
        $validated = $request->validate([
            'informant_id' => 'required|exists:informants,id',
            'category_id' => 'required|exists:report_categories,id',
            'reported_name.*' => 'required|string|max:255', // multiple names
            'reported_unit.*' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Simpan report utama
        $report = Report::create([
            'informant_id' => $validated['informant_id'],
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'status_id' => $validated['status_id'],
        ]);

        // Simpan semua terlapor
        foreach ($request->reported_name as $index => $name) {
            ReportedParty::create([
                'report_id' => $report->id,
                'reported_name' => $name,
                'reported_unit' => $request->reported_unit[$index] ?? null,
            ]);
        }

        return redirect()->route('report')->with('success', 'Laporan berhasil dikirim!');
    }
}
