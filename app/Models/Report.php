<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    const CREATED_AT = 'reported_at';
    const UPDATED_AT = null;

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
        'incident_time' => 'datetime',
    ];

    // Relasi ke Informant
    public function informant(): BelongsTo
    {
        return $this->belongsTo(Informant::class);
    }

    // Relasi ke Report Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(ReportCategory::class, 'category_id');
    }

    // Relasi ke Status
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // Relasi ke FollowUp
    public function followUp(): HasOne
    {
        return $this->hasOne(FollowUp::class);
    }

    // Relasi ke ReportedParties
    public function reportedParties(): HasMany
    {
        return $this->hasMany(ReportedParty::class);
    }

    // Relasi ke Attachments
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}
