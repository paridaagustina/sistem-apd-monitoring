
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apd_inspections', function (Blueprint $table) {
            $table->id();

            // Petugas yang melakukan pemeriksaan
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();

            // Status keseluruhan pemeriksaan
            $table->string('status')->default('incomplete');

            // Lokasi penyimpanan video pemeriksaan
            $table->string('evidence_path')->nullable();

            // Catatan tambahan dari petugas
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apd_inspections');
    }
};
