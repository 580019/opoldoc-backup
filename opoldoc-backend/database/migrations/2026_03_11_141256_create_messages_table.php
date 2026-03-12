<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
       Schema::create('messages', function (Blueprint $table) {

    $table->id('message_id');

    $table->unsignedBigInteger('user_id');

    $table->enum('sender', ['user', 'bot']);

    $table->text('message_text');

    $table->timestamps();

    $table->foreign('user_id')
        ->references('user_id')
        ->on('users')
        ->cascadeOnDelete();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
