<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCategory;
use App\Models\Status;
use App\Models\Informant;
use App\Models\Report;
use App\Models\ReportedParty;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        // Validasi input
        $validated = $request->validate([
            'informant_id' => 'required|exists:informants,id',
            'category_id' => 'required|exists:report_categories,id',
            'reported_name.*' => 'required|string|max:255',
            'reported_unit.*' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Generate unique token
        do {
            $token = Str::upper(Str::random(6));
        } while (Report::where('token', $token)->exists());

        // Simpan report
        $report = Report::create([
            'token' => $token,
            'informant_id' => $validated['informant_id'],
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'status_id' => $validated['status_id'],
        ]);

        // Simpan data terlapor
        foreach ($request->reported_name as $index => $name) {
            ReportedParty::create([
                'report_id' => $report->id,
                'reported_name' => $name,
                'reported_unit' => $request->reported_unit[$index] ?? null,
            ]);
        }

        // Redirect ke halaman berhasil sambil membawa token
        return redirect()->route('report.success', ['token' => $token]);
    }

    // Halaman setelah berhasil kirim laporan
    public function success($token)
    {
        $report = Report::where('token', $token)->firstOrFail();

        return view('pages.report-success', [
            'token' => $report->token,
        ]);
    }
}
