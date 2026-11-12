<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ccv_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ccv_observation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('risk_code');
            $table->string('question_key');
            $table->text('question_text');

            $table->enum('answer', ['ya', 'tidak']);

            $table->timestamps();

            $table->unique([
                'ccv_observation_id',
                'question_key'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ccv_answers');
    }
};