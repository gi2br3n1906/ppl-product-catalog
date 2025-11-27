    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('product_images', function (Blueprint $table) {
        $table->id();
        // Ini kunci utamanya: Relasi ke tabel products
        // onDelete('cascade') artinya jika produk dihapus, gambarnya ikut terhapus otomatis
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

        $table->string('image_path'); // Lokasi file gambar
        $table->boolean('is_primary')->default(false); // Opsional: untuk nandain gambar utama
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
