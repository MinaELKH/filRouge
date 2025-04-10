<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // L'expéditeur
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // Le destinataire
            $table->string('subject'); // Le sujet du message
            $table->text('body'); // Le corps du message
            $table->enum('status', ['sent', 'read', 'archived'])->default('sent'); // Statut du message
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
