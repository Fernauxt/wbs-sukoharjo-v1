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
        // Fetch report by ID
        $report = Report::findOrFail($id);

        // Return view with report details
        return view('admin.reports.details', compact('report'));
    }

    public function update(Request $request, $id)
    {

        // Input validation
        $validated = $request->validate([
            'status' => 'required|string|in:diproses,perlu-klarifikasi,selesai,ditolak', 
            'notes' => 'nullable|string',
            'evidence' => 'sometimes|array|max:5',
            'evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);
        
        // Search by ID
        $report = Report::findOrFail($id);

        // Update report status
        $status = Status::where('slug', $validated['status'])->firstOrFail();
        $report->status_id = $status->id;
        $report->save();

        // Update or create follow-up record
        $followUp = $report->followUp()->updateOrCreate(
            ['report_id' => $report->id],
            [
                'status_id' => $status->id,
                'notes' => $validated['notes'] ?? null,
            ]
        );

        // Handle evidence file if uploaded
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

        // Notify informant via email if email exists
        if ($report->informant->email) {
            Mail::to($report->informant->email)->send(
                new ReportUpdateMail($report, $validated['status'], $validated['notes'] ?? null)
            );
        }

        // Redirect to report details with success message
        return redirect()->route('admin.reports.show', $id)
            ->with('success', 'Laporan berhasil diperbarui.');
    }
    
    
}
