<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->string('ijazah', 255)->nullable()->after('transfer');
            $table->enum('status_pendaftaran', ['Menunggu', 'Diterima', 'Ditolak'])->default('Menunggu')->after('ijazah');
            $table->text('alasan_penolakan')->nullable()->after('status_pendaftaran');
            $table->dateTime('tgl_verifikasi')->nullable()->after('alasan_penolakan');
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropColumn(['ijazah', 'status_pendaftaran', 'alasan_penolakan', 'tgl_verifikasi']);
        });
    }
};
