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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
        $admins = Admin::all();
;
        // Input validation
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

            'evidence' => 'nullable|array|max:5',
            'evidence.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip|max:5120',
        ]);

    

        // Store informant's data
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

        // Store report data
        $report = Report::create([
            'token' => $token,
            'informant_id' => $informant->id,
            'category_id' => $validated['category_id'],
            'subject' => $validated['violation_subject'],
            'description' => $validated['violation_desc'],
            'location' => $validated['location'],
            'incident_time' => Carbon::parse($validated['datetime']),
            'status_id' => 1, // Default "Terkirim" (sent)
            'reported_at' => now(),
        ]);

        $followups = FollowUp::create([
            'report_id' => $report->id,
            'status_id' => 1, // Default "Terkirim" (sent)
            'notes' => 'Laporan telah berhasil dikirim dan sedang menunggu verifikasi.',
        ]);

        // Store reported parties data
        foreach ($validated['reported_name'] as $i => $name) {
            ReportedParty::create([
                'report_id' => $report->id,
                'reported_name' => $name,
                'reported_unit' => $validated['reported_unit'][$i] ?? null,
            ]);
        }

        // Store evidence attachments if exists
        if ($request->hasFile('evidence')) {
            // Upload to Cloudinary
            // 'wbs_evidence' are the folder name in Cloudinary
            $files = $request->file('evidence');
            if(!is_array($files)){
                $files = [$files];
            }

            foreach ($files as $file) {
                $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'wbs_evidence',
                ])->getSecurePath();

                Attachment::create([
                    'report_id' => $report->id,
                    'file_path' => $uploadedFileUrl,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        // if ($request->hasFile('evidence')) {
        //     // Local storage approach
        //     foreach ($request->file('evidence') as $file) {
        //         $path = $file->store('attachments', 'public');

        //         Attachment::create([
        //             'report_id' => $report->id,
        //             'file_path' => $path,
        //             'file_name' => $file->getClientOriginalName(),
        //             'file_type' => $file->getClientMimeType(),
        //         ]);
        //     }

        //     // Vercel read-only approach (skip upload).
        //     // try {
        //     //     // Try to store file
        //     //     $path = $request->file('evidence')->store('public/attachments');
                
        //     //     // If successful, save path to report
        //     //     $report->evidence = $path;
        //     //     $report->save(); 
                
        //     // } catch (\Exception $e) {
        //     //     // If fails, log the error
        //     //     // Do not let the whole process fail just because of file upload
        //     //     \Log::error('Gagal upload file di environment ini: ' . $e->getMessage());
                
        //     //     // Optional: Give flash warning to user
        //     //     // session()->flash('warning', 'Laporan terkirim, namun bukti gagal diunggah karena batasan server demo.');
        //     // }
        // }

        // Send email to informant if provided
        if ($informant->email)
        {
            Mail::to($informant->email)->send(new ReportTokenMail($report));
        }

        // Send email to all admins about new reports
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new IncomingReportMail($report, $admin));
        }


        // Redirect to success page with token
        return redirect()->route('report.success', ['token' => $token]);
    }

    // Page after successful report submission
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
        
        // Handle form submission
        if ($request->isMethod('post')) {
            $request->validate(['token' => 'required|string|max:6']);
            
            // Search report by token
            $report = Report::with('reportedParties', 'status', 'followUp')
                ->where('token', strtoupper($request->token))
                ->first();

            // Show error if not found
            if (!$report) {
                return redirect()->route('report.track')->with('error', true);
            }
        }

        return view('pages.track-report', compact('report', 'error'));
    }
}
