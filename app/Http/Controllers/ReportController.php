<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportCategory;
use App\Models\Status;
use App\Models\Informant;
use App\Models\InformantType;
use App\Models\Report;
use App\Models\ReportedParty;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Attachment;
use App\Models\FollowUp;
use App\Models\FollowUpAttachment;

class ReportController extends Controller
{
    public function create()
    {
        return view('pages.create-report', [
            'categories' => ReportCategory::all(),
            'statuses' => Status::all(),
            'informants' => Informant::all(),
            'informant_types' => InformantType::all()
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        // Validasi input
        $validated = $request->validate([
            'informant_name' => 'required|string|max:255',
            'informant_type_id' => 'required|exists:informant_types,id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',

            'category_id' => 'required|exists:report_categories,id',

            'reported_name.*' => 'required|string|max:255',
            'reported_unit.*' => 'nullable|string|max:255',

            'violation_subject' => 'required|string|max:255',
            'violation_desc' => 'required|string',
            'location' => 'required|string|max:255',
            'datetime' => 'required|date',

            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

        // Simpan informant
        $informant = Informant::create([
            'name' => $validated['informant_name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'type_id' => $validated['informant_type_id'],
        ]);

        // Generate unique token
        do {
            $token = Str::upper(Str::random(6));
        } while (Report::where('token', $token)->exists());

        // Simpan report
        $report = Report::create([
            'token' => $token,
            'informant_id' => $informant->id,
            'category_id' => $validated['category_id'],
            'subject' => $validated['violation_subject'],
            'description' => $validated['violation_desc'],
            'location' => $validated['location'],
            'incident_time' => $validated['datetime'],
            'status_id' => 1, // Default "Terkirim"
        ]);

        $followups = FollowUp::create([
            'report_id' => $report->id,
            'status_id' => 1, // Default "Terkirim"
            'notes' => 'Laporan telah berhasil dikirim dan sedang menunggu verifikasi.',
            'modified_at' => now(),
            'created_at' => now(),
        ]);

        FollowUpAttachment::create([
            'follow_up_id' => $followups->id,
            'file_path' => null,
            'file_name' => null,
            'file_type' => null,
        ]);

        // Simpan data terlapor
        foreach ($validated['reported_name'] as $i => $name) {
            ReportedParty::create([
                'report_id' => $report->id,
                'reported_name' => $name,
                'reported_unit' => $validated['reported_unit'][$i] ?? null,
            ]);
        }

        // Simpan attachment (jika ada)
        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $path = $file->store('attachments', 'public');

            Attachment::create([
                'report_id' => $report->id,
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $file->getClientMimeType(),
            ]);
        }

        // Redirect ke halaman berhasil sambil membawa token
        return redirect()->route('report.success', ['token' => $token]);
    }

    // Halaman setelah berhasil kirim laporan
    public function success($token)
    {
        $report = Report::where('token', $token)->firstOrFail();

        return view('pages.success', [
            'token' => $report->token,
        ]);
    }

    public function track(Request $request)
    {
        // return view('pages.track-report');
        $report = null;
        $error = false;

        if ($request->isMethod('post')) {
            $request->validate(['token' => 'required|string|max:6']);

            $report = Report::with('reportedParties', 'status', 'followUp')
                ->where('token', strtoupper($request->token))
                ->first();

            if (!$report) {
                return redirect()->route('report.track')->with('error', true);
            }
        }

        return view('pages.track-report', compact('report', 'error'));
    }
}
