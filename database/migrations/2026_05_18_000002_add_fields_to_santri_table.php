<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->string('no_induk', 50)->nullable()->after('alamat');
            $table->string('nik', 16)->nullable()->after('no_induk');
            $table->string('nisn', 10)->nullable()->after('nik');
            $table->string('nama_ayah', 100)->nullable()->after('alamat');
            $table->string('no_hp_ayah', 15)->nullable()->after('nama_ayah');
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn(['no_induk', 'nik', 'nisn', 'nama_ayah', 'no_hp_ayah']);
        });
    }
};