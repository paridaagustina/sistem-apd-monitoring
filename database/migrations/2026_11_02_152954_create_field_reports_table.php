<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('field_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('location_name', 255);

            $table->dateTime('started_at');
            $table->dateTime('ended_at');
            $table->dateTime('submitted_at');

            $table->string('video_path');

            $table->unsignedInteger('video_duration')->default(0);
            $table->unsignedBigInteger('video_size')->default(0);

            $table->string('status')->default('menunggu');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'submitted_at']);
            $table->index(['status', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('field_reports');
    }
};