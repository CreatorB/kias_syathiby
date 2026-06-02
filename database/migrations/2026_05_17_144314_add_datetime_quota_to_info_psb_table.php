<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->dateTime('datetime_open')->nullable()->after('biaya_pendaftaran');
            $table->dateTime('datetime_closed')->nullable()->after('datetime_open');
            $table->unsignedInteger('quota_ikhwan')->nullable()->after('datetime_closed');
            $table->unsignedInteger('quota_akhwat')->nullable()->after('quota_ikhwan');
        });
    }

    public function down(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->dropColumn(['datetime_open', 'datetime_closed', 'quota_ikhwan', 'quota_akhwat']);
        });
    }
};