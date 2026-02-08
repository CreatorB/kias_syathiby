<?php

namespace App\Models;

use App\Models\Kitab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisProgram extends Model
{
    use HasFactory;

    protected $table = 'jenis_program';
    protected $guarded = ['id'];

    public function kitab(): HasMany
    {
        return $this->hasMany(Kitab::class, 'jenis_program_id', 'id');
    }
}
