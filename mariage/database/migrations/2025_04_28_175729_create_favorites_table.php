// database/migrations/xxxx_xx_xx_create_favorites_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // S'assurer qu'un utilisateur ne peut pas ajouter le même service deux fois
            $table->unique(['user_id', 'service_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
