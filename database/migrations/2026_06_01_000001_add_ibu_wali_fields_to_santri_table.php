<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->string('nama_ibu', 100)->nullable()->after('no_hp_ayah');
            $table->string('no_hp_ibu', 15)->nullable()->after('nama_ibu');
            $table->string('nama_wali', 100)->nullable()->after('no_hp_ibu');
            $table->string('no_hp_wali', 15)->nullable()->after('nama_wali');
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn(['nama_ibu', 'no_hp_ibu', 'nama_wali', 'no_hp_wali']);
        });
    }
};