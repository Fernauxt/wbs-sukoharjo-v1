<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Informant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type_id',
    ];

    // Relasi ke tipe informan (ASN/Masyarakat)
    public function type(): BelongsTo
    {
        return $this->belongsTo(InformantType::class, 'type_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
