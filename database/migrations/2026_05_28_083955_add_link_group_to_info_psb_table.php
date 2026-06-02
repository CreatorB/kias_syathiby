<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->string('link_group', 500)->nullable()->after('biaya_spp_bulanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->dropColumn('link_group');
        });
    }
};
