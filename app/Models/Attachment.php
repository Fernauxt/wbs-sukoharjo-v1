<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';

    protected $fillable = [
        'report_id',
        'file_path',
        'file_type',
        'original_name',
        'description'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
