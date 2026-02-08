<?php

namespace App\Models;

use App\Models\Cabang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TesMasuk extends Model
{
    use HasFactory;

    protected $table = 'tes_masuk_psb';
    protected $guarded = [];

    public function cabang(): HasOne
    {
        return $this->hasOne(Cabang::class, 'id', 'cabang_id');
    }
}
