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
    Schema::create('workers', function (Blueprint $table) {
        $table->id();

        // Nomor identitas pekerja, misalnya PKR-001
        $table->string('worker_code', 30)->unique();

        // Identitas utama pekerja
        $table->string('name', 100);
        $table->string('department', 100)->nullable();
        $table->string('position', 100)->nullable();

        // Aktif atau nonaktif
        $table->boolean('is_active')->default(true);

        $table->text('notes')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
