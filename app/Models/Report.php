<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'informant_id',
        'category_id',
        'reported_name',
        'reported_unit',
        'subject',
        'description',
        'location',
        'incident_time',
        'attachments',
        'status_id',
        'reported_at'
    ];

    public function informant()
    {
        return $this->belongsTo(Informant::class, 'informant_id');
    }

    public function category()
    {
        return $this->belongsTo(ReportCategory::class, 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'report_id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'report_id');
    }

    public function reportedPersons()
    {
        return $this->hasMany(ReportedPerson::class, 'report_id');
    }

    public function reportedParties()
    {
        return $this->hasMany(ReportedParty::class);
    }
}
