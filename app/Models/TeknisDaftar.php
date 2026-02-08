<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknisDaftar extends Model
{
    use HasFactory;

    protected $table = 'teknis_daftar_psb';
    protected $guarded = [];
}
