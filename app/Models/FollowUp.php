<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'follow_ups';

    public $timestamps = false;

    protected $fillable = [
        'report_id',
        'notes',
        'status_id',
        // 'modified_at',
        // 'created_at'
    ];
    protected $casts = [
        'modified_at' => 'datetime',
        'created_at' => 'datetime',
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