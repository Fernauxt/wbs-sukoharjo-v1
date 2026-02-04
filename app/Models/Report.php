<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    protected $fillable = [
        'token',
        'informant_id',
        'category_id',
        'subject',
        'description',
        'location',
        'incident_time',
        'status_id',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public $timestamps = false;
    
    // Relation to Informant table
    public function informant(): BelongsTo
    {
        return $this->belongsTo(Informant::class);
    }

    // Relation to ReportCategory table
    public function category(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class, 'category_id');
    }

    // Relation to Status table
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // Relation to FollowUp table
    public function followUp(): HasOne
    {
        return $this->hasOne(FollowUp::class);
    }

    // Relation to ReportedParties table
    public function reportedParties(): HasMany
    {
        return $this->hasMany(ReportedParty::class);
    }

    // Relation to Attachments table
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
