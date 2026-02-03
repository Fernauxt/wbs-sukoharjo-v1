<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Status;
use App\Models\FollowUp;
use App\Mail\ReportUpdateMail;
use Illuminate\Support\Facades\Mail;

class AdminReportController extends Controller
{
    //
    public function index(Request $request)
    {
        $statuses = Status::all();
        $query = Report::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status_id', $request->status);
        }

        $reports = $query->with(['informant', 'category', 'status'])
                         ->latest('reported_at')
                         ->get();

        return view('admin.reports.index', compact('reports', 'statuses'));
    }


    public function show($id)
    {
        $report = Report::with(['status', 'category', 'informant', 'attachments', 'followUp.attachments'])->findOrFail($id);

        $statuses = Status::all();

        return view('admin.reports.details', compact('report', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        // Cari laporan berdasarkan ID
        $report = Report::findOrFail($id);
        
        // Validasi input
        $validated = $request->validate([
            'status_id' => 'required|exists:statuses,id',
            'notes' => 'nullable|string',
            'evidence' => 'nullable|array|max:5',
            'evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

        // Update status laporan
        $report->update([
            'status_id' => $validated['status_id']
        ]);

        // Update atau buat data tindak lanjut
        $followUp = FollowUp::updateOrCreate(
            ['report_id' => $report->id],
            [
                'status_id' => $validated['status_id'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        // Proses file bukti pendukung jika ada
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('follow_up_attachments', 'public');
                
                // Pastikan Anda sudah membuat relasi 'attachments()' di model FollowUp
                $followUp->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getMimeType(),
                ]);
            }
        }

        // Email notif ke pelapor (jika tanpa email, skip)
        // if ($report->informant->email) {
        //     Mail::to($report->informant->email)->send(
        //         new ReportUpdateMail($report, $validated['status'], $validated['notes'] ?? null)
        //     );
        // }

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui.');
    }
    
    
}
