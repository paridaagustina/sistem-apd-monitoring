
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apd_inspection_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inspection_id')
                ->constrained('apd_inspections')
                ->cascadeOnDelete();

            $table->foreignId('apd_item_id')
                ->constrained('apd_items')
                ->cascadeOnDelete();

            // Checklist manual: dicentang atau tidak
            $table->boolean('is_detected')->default(false);

            // Akan digunakan ketika AI sudah terintegrasi
            $table->decimal('confidence', 5, 4)->nullable();

            $table->string('status')->default('incomplete');

            $table->timestamps();

            // Satu jenis APD hanya memiliki satu detail
            // dalam satu pemeriksaan
            $table->unique([
                'inspection_id',
                'apd_item_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apd_inspection_details');
    }
};
