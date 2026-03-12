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
       Schema::create('chatbot_options', function (Blueprint $table) {
            $table->id('option_id');

            $table->foreignId('question_id')
                ->constrained('chatbot_questions', 'question_id')
                ->cascadeOnDelete();

            $table->string('option_text');

            $table->text('response_text');

            $table->foreignId('next_question_id')
                ->nullable()
                ->constrained('chatbot_questions', 'question_id')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_options');
    }
};
