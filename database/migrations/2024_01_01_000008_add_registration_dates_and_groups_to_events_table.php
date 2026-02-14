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
        Schema::table('events', function (Blueprint $table) {
            // Registration period
            $table->datetime('registration_start')->nullable()->after('end_date');
            $table->datetime('registration_end')->nullable()->after('registration_start');

            // WhatsApp Group links
            $table->string('group_ikhwan')->nullable()->after('status');
            $table->string('group_akhwat')->nullable()->after('group_ikhwan');
            $table->string('group_public')->nullable()->after('group_akhwat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'registration_start',
                'registration_end',
                'group_ikhwan',
                'group_akhwat',
                'group_public',
            ]);
        });
    }
};
