<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformantType extends Model
{
    protected $table = 'informant_types';

    protected $fillable = ['name'];

    public function informants()
    {
        return $this->hasMany(Informant::class, 'type_id');
    }
}
