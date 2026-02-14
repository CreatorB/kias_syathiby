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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content');
            $table->string('image')->nullable();
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->boolean('is_paid')->default(false);
            $table->decimal('price', 12, 2)->default(0);
            $table->boolean('has_attendance')->default(false);
            $table->boolean('has_certificate')->default(false);
            $table->string('certificate_template')->nullable();
            $table->string('certificate_font')->default('Arial');
            $table->string('certificate_font_color')->default('#000000');
            $table->integer('certificate_font_size')->default(24);
            $table->integer('certificate_name_x')->default(400);
            $table->integer('certificate_name_y')->default(300);
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
