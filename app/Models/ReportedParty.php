<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedParty extends Model
{
    protected $fillable = [
        'report_id',
        'reported_name',
        'reported_unit',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
