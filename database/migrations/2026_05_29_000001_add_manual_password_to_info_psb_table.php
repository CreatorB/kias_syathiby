<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->string('manual_password', 255)->nullable()->after('link_group');
        });
    }

    public function down(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->dropColumn('manual_password');
        });
    }
};
