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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('prescription_id');
            $table->unsignedBigInteger('visit_id')->unique();
            $table->unsignedBigInteger('doctor_profile_id');
            $table->date('prescribed_date');
            $table->string('signature_path', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('visit_id')
                ->references('visit_id')
                ->on('visits')
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
        Schema::dropIfExists('prescriptions');
    }
};
