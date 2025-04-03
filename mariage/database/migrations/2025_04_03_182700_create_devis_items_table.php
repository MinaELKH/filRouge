<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('devis_id'); // Référence au devis
            $table->string('service_name'); // Nom du service
            $table->integer('quantity')->default(1); // Quantité du service
            $table->decimal('unit_price', 10, 2); // Prix unitaire du service
            $table->decimal('total_price', 10, 2); // Prix total pour cette ligne (quantity * unit_price)
            $table->timestamps();

            // Relation avec le devis
            $table->foreign('devis_id')->references('id')->on('devis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis_items');
    }
}
