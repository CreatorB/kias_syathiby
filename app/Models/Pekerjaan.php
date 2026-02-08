<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';
    protected $guarded = [];

    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'pekerjaan_id', 'id');
    }
}
