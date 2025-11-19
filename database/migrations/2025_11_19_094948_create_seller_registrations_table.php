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
        Schema::create('seller_registrations', function (Blueprint $table) {
            $table->id();
            
            // Data Toko
            $table->string('nama_toko');
            $table->text('deskripsi_singkat');
            
            // Data PIC
            $table->string('nama_pic');
            $table->string('no_hp_pic');
            $table->string('email_pic')->unique();
            
            // Alamat PIC
            $table->string('jalan');
            $table->string('rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->string('kab_kota');
            $table->string('provinsi');
            
            // Dokumen Identitas PIC
            $table->string('no_ktp_pic');
            $table->string('foto_pic')->nullable(); // path to file
            $table->string('file_ktp')->nullable(); // path to file
            
            // Password
            $table->string('password');
            
            // Status verifikasi
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_registrations');
    }
};
