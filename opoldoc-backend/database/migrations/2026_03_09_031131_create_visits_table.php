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
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('visit_id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('patient_profile_id');
            $table->unsignedBigInteger('doctor_profile_id');
            $table->dateTime('visit_date');
            $table->text('reason_for_visit')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment_notes')->nullable();
            $table->unsignedBigInteger('prescription_id')->nullable()->unique();
            $table->timestamps();

            $table->foreign('appointment_id')
                ->references('appointment_id')
                ->on('appointments')
                ->nullOnDelete()
                ->cascadeOnUpdate();

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
        Schema::dropIfExists('visits');
    }
};
