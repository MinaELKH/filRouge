<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id'); // Référence à la réservation
            $table->decimal('total_amount', 10, 2)->default(0); // Montant total du devis
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Statut du devis
            $table->timestamps();

            // Relation avec la réservation
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devis');
    }
}
