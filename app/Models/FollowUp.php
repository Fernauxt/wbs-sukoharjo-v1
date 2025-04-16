<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'follow_ups';

    protected $fillable = [
        'report_id',
        'notes',
        'status_id',
    ];


    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function attachments()
    {
        return $this->hasMany(FollowUpAttachment::class);
    }
}