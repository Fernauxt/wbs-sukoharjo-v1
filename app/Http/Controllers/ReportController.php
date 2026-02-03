<?php

namespace App\Http\Controllers;

use App\Mail\IncomingReportMail;
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
use App\Mail\ReportTokenMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;

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

        $admins = Admin::all();
        
        // Validate input
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
            'datetime' => 'required|date_format:Y-m-d\TH:i',

            'evidence' => 'nullable|array|max:5',
            'evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

    
        // Save informant
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

        // --- BAGIAN YANG DIUBAH (Mencari ID Status secara Dinamis) ---
        $statusAwal = Status::where('name', 'Terkirim')->first();
        // Jika status 'Terkirim' ketemu, pakai ID-nya. Jika tidak, pakai ID 1.
        $statusId = $statusAwal ? $statusAwal->id : 1; 
        // -------------------------------------------------------------

        // Save report
        $report = Report::create([
            'token' => $token,
            'informant_id' => $informant->id,
            'category_id' => $validated['category_id'],
            'subject' => $validated['violation_subject'],
            'description' => $validated['violation_desc'],
            'location' => $validated['location'],
            'incident_time' => Carbon::parse($validated['datetime']),
            'status_id' => $statusId,
            'reported_at' => Carbon::now(),
        ]);

        $followups = FollowUp::create([
            'report_id' => $report->id,
            'status_id' => $statusId,
            'notes' => 'Laporan telah berhasil dikirim dan sedang menunggu verifikasi.',
        ]);

        // Save reported parties
        foreach ($validated['reported_name'] as $i => $name) {
            ReportedParty::create([
                'report_id' => $report->id,
                'reported_name' => $name,
                'reported_unit' => $validated['reported_unit'][$i] ?? null,
            ]);
        }

        // Save attachments if there are any
        if ($request->hasFile('evidence')) {
            foreach ($request->file('evidence') as $file) {
                $path = $file->store('attachments', 'public');

                Attachment::create([
                    'report_id' => $report->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        // Send email to informant
        if ($informant->email)
        {
            Mail::to($informant->email)->send(new ReportTokenMail($report));
        }

        // Send email to all admins
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new IncomingReportMail($report, $admin));
        }

        // Redirect to success page with token
        return redirect()->route('report.success', ['token' => $token]);
    }

    // Success page after report submission
    public function success($token)
    {
        $report = Report::where('token', $token)->firstOrFail();

        return view('pages.success', [
            'token' => $report->token,
        ]);
    }


    public function track(Request $request)
    {
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