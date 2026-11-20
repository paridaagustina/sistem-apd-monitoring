
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_checks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nama_petugas');
            $table->string('unit');
            $table->date('tanggal_periksa');
            $table->string('usia');
            $table->string('perusahaan');

            $table->integer('sistolik');
            $table->integer('diastolik');

            $table->string('status_sistolik');
            $table->string('status_diastolik');
            $table->string('status_tensi');

            $table->integer('hasil_oximeter');
            $table->string('status_oximeter');

            $table->string('kesimpulan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_checks');
    }
};
