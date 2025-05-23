<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportCategory extends Model
{
    protected $table = 'report_categories';

    protected $fillable = ['name', 'slug'];

    public function reports()
    {
        return $this->hasMany(Report::class, 'category_id');
    }
}
