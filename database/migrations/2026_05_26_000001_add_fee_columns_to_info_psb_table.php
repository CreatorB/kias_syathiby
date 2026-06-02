<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->integer('biaya_sarana_prasana')->default(300000)->after('biaya_pendaftaran');
            $table->integer('biaya_kuliah_perdana')->default(250000)->after('biaya_sarana_prasana');
            $table->integer('biaya_spp_bulanan')->default(250000)->after('biaya_kuliah_perdana');
        });
    }

    public function down(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->dropColumn(['biaya_sarana_prasana', 'biaya_kuliah_perdana', 'biaya_spp_bulanan']);
        });
    }
};
