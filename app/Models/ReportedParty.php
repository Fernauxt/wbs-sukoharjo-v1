<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedParty extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'reported_name',
        'reported_unit',
    ];

    // Relasi ke model Report
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
