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
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('file_id');
            $table->unsignedBigInteger('patient_profile_id');
            $table->string('file_type', 50);
            $table->string('file_path', 255);
            $table->timestamp('uploaded_at')->useCurrent();

            $table->foreign('patient_profile_id')
                ->references('patient_profile_id')
                ->on('patient_profiles')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
