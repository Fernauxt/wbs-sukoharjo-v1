<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = ['name', 'slug'];

    public function reports()
    {
        return $this->hasMany(Report::class, 'status_id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'status_id');
    }
}
