
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Mengubah kolom answer agar dapat menyimpan pilihan RC3.
     */
    public function up(): void
    {
        Schema::table('ccv_answers', function (Blueprint $table) {
            $table->string('answer', 100)->change();
        });
    }

    /**
     * Tidak mengembalikan ke enum karena data RC3
     * mungkin sudah tersimpan di database.
     */
    public function down(): void
    {
        // Kolom tetap menggunakan tipe string.
    }
};
