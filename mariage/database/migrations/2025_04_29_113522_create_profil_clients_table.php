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
        Schema::create('profil_clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ville_id')->nullable()->constrained()->onDelete('set null');
            $table->date('date_event')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->decimal('budget_spent', 10, 2)->nullable()->default(0);
            $table->integer('nombre_invites')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_clients');
    }
};
