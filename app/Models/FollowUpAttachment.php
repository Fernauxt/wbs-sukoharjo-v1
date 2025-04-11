<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUpAttachment extends Model
{
    protected $table = 'follow_up_attachments'; 
    protected $fillable = [
        'follow_up_id',
        'file_path',
        'file_name',
        'file_type',
    ];

    public function followUp()
    {
        return $this->belongsTo(FollowUp::class);
    }
}
