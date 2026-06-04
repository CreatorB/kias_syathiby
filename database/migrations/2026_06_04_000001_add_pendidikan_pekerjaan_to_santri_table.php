<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            if (!Schema::hasColumn('santri', 'pendidikan')) {
                $table->string('pendidikan', 50)->nullable()->after('pekerjaan_id');
            }
            if (!Schema::hasColumn('santri', 'pekerjaan')) {
                $table->string('pekerjaan', 100)->nullable()->after('pendidikan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn(['pendidikan', 'pekerjaan']);
        });
    }
};