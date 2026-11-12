<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ccv_observations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Identitas observer
            $table->string('observer_name');
            $table->string('company');
            $table->string('position');
            $table->string('department')->nullable();

            // Informasi pekerjaan
            $table->string('unit_induk')->default('UID KALSELTENG');
            $table->string('work_location');
            $table->string('work_order_number')->nullable();
            $table->string('executing_unit');
            $table->string('customer_service_unit')->nullable();

            // Risk Containment
            $table->boolean('supervisor_present');
            $table->string('risk_code');
            $table->string('other_risk')->nullable();

            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ccv_observations');
    }
};