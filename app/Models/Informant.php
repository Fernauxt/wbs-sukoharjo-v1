<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Informant extends Model
{
    use SoftDeletes;

    protected $table = 'informants';

    protected $fillable = ['name', 'email', 'phone', 'type_id'];

    public function type()
    {
        return $this->belongsTo(InformantType::class, 'type_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'informant_id');
    }
}
