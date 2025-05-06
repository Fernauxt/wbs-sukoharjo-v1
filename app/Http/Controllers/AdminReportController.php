<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Status;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use App\Mail\ReportUpdateMail;
use Illuminate\Support\Facades\Mail;

class AdminReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $statuses = Status::all();
        $query = Report::query();

        // Apply filter if 'status' is provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status_id', $request->status);
        }

        $reports = $query->with(['informant', 'category', 'status'])->get();

        return view('admin.reports.index', compact('reports', 'statuses'));
    }


    public function show($id)
    {
        // Ambil laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Kembalikan view dengan data laporan
        return view('admin.reports.details', compact('report'));
    }

    public function update(Request $request, $id)
    {

        // Validasi input
        $validated = $request->validate([
            'status' => 'required|string|in:in-review,need-clarify,resolved',
            'notes' => 'nullable|string',
            'evidence' => 'sometimes|array|max:5',
            'evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

        // Cari laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Update status laporan
        $status = Status::where('slug', $validated['status'])->firstOrFail();
        $report->status_id = $status->id;
        $report->save();

        // Update atau buat data tindak lanjut
        $followUp = $report->followUp()->updateOrCreate(
            ['report_id' => $report->id],
            [
                'status_id' => $status->id,
                'notes' => $validated['notes'] ?? null,
            ]
        );

        // Proses file bukti pendukung jika ada
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('follow_up_attachments', 'public');
                $followUp->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                ]);
            }
        }

        // Email notif ke pelapor (jika tanpa email, skip)
        if ($report->informant->email) {
            Mail::to($report->informant->email)->send(
                new ReportUpdateMail($report, $validated['status'], $validated['notes'] ?? null)
            );
        }

        // Redirect dengan pesan sukses
        return redirect()->route('admin.reports.show', $id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }
    
    
}
