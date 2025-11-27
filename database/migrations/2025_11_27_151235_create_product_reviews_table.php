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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Data pengunjung (tidak perlu login)
            $table->string('reviewer_name');
            $table->string('reviewer_phone', 20);
            $table->string('reviewer_email');
            
            // Rating dan komentar
            $table->tinyInteger('rating')->unsigned()->comment('Rating 1-5');
            $table->text('comment')->nullable()->comment('Komentar/ulasan produk');
            
            // Status notifikasi email
            $table->boolean('email_sent')->default(false)->comment('Status pengiriman email terima kasih');
            $table->timestamp('email_sent_at')->nullable()->comment('Waktu pengiriman email');
            
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('rating');
            $table->index('reviewer_email');
            $table->index(['product_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};