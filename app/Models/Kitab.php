<?php

namespace App\Models;

use App\Models\JenisProgram;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kitab extends Model
{
    use HasFactory;

    protected $table = 'kitab';
    protected $guarded = ['id'];

    public function jenisProgram(): BelongsTo
    {
        return $this->belongsTo(JenisProgram::class, 'jenis_program_id', 'id');
    }
}
