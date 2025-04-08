<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedPerson extends Model
{
    //
    protected $table = 'reported_persons';

    protected $fillable = ['report_id', 'name', 'unit'];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
