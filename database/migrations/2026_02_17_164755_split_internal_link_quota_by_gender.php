<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('event_internal_links', function (Blueprint $table) {
            $table->integer('quota_ikhwan')->default(0)->after('name');
            $table->integer('quota_akhwat')->default(0)->after('quota_ikhwan');
            $table->integer('usage_ikhwan')->default(0)->after('quota_akhwat');
            $table->integer('usage_akhwat')->default(0)->after('usage_ikhwan');
            $table->dropColumn(['quota', 'usage_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_internal_links', function (Blueprint $table) {
            $table->integer('quota')->after('name');
            $table->integer('usage_count')->default(0)->after('quota');
            $table->dropColumn(['quota_ikhwan', 'quota_akhwat', 'usage_ikhwan', 'usage_akhwat']);
        });
    }
};
