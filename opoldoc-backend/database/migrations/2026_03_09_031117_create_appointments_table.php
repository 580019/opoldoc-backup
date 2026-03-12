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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('appointment_id');
            $table->unsignedBigInteger('patient_profile_id');
            $table->unsignedBigInteger('doctor_profile_id');
            $table->dateTime('appointment_date');
            $table->string('visit_status', 20);
            $table->integer('queue_number')->nullable();
            $table->timestamps();

            $table->foreign('patient_profile_id')
                ->references('patient_profile_id')
                ->on('patient_profiles')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('doctor_profile_id')
                ->references('doctor_profile_id')
                ->on('doctor_profiles')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
