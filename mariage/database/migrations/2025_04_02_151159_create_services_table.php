<?PHP
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
/**
* Run the migrations.
*/
public function up(): void
{
Schema::create('services', function (Blueprint $table) {
$table->id();
$table->string('title');
$table->text('description')->nullable();
$table->decimal('price', 10, 2)->nullable();
$table->string('cover_image'); // Image de couverture
$table->json('gallery')->nullable(); // Galerie d'images
$table->foreignId('category_id')->constrained()->onDelete('cascade'); // Catégorie du service
$table->foreignId('user_id')->constrained()->onDelete('cascade'); // Prestataire
$table->foreignId('ville_id')->constrained()->onDelete('cascade'); // Ville du service
$table->enum('status', ['pending', 'approved', 'archived'])->default('pending'); // Statut du service
$table->timestamps();
});
}

/**
* Reverse the migrations.
*/
public function down(): void
{
Schema::dropIfExists('services');
}
};
