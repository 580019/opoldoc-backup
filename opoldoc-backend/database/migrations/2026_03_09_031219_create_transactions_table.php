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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->unsignedBigInteger('visit_id')->unique();
            $table->unsignedBigInteger('patient_profile_id');
            $table->decimal('amount', 10, 2);
            $table->string('payment_mode', 20);
            $table->string('payment_status', 20);
            $table->string('reference_number', 50)->nullable();
            $table->string('receipt_path', 255)->nullable();
            $table->timestamps();

            $table->foreign('visit_id')
                ->references('visit_id')
                ->on('visits')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('patient_profile_id')
                ->references('patient_profile_id')
                ->on('patient_profiles')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
