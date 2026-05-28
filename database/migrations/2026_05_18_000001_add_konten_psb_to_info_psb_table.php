<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->text('konten_psb')->nullable()->after('biaya_transkrip');
            $table->json('poster_images')->nullable()->after('konten_psb');
        });
    }

    public function down(): void
    {
        Schema::table('info_psb', function (Blueprint $table) {
            $table->dropColumn(['konten_psb', 'poster_images']);
        });
    }
};