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
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');

        Schema::create('admins', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nama_admin');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('templates', function (Blueprint $table) {
            $table->id('id_template');
            $table->string('nama_template');
            $table->unsignedInteger('jumlah_template')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });

        Schema::create('websites', function (Blueprint $table) {
            $table->id('id_website');
            $table->foreignId('id_admin')->constrained('admins', 'id_admin')->cascadeOnDelete();
            $table->foreignId('id_template')->constrained('templates', 'id_template')->restrictOnDelete();
            $table->string('bio')->nullable();
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('contact')->nullable();
            $table->enum('status', ['draft', 'aktif', 'nonaktif'])->default('draft');
            $table->timestamps();
        });

        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->foreignId('id_website')->constrained('websites', 'id_website')->cascadeOnDelete();
            $table->string('nama_produk');
            $table->text('deskripsi_produk')->nullable();
            $table->string('foto_produk')->nullable();
            $table->unsignedBigInteger('harga')->default(0);
            $table->unsignedInteger('jumlah_produk')->default(0);
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('id_activity_log');
            $table->foreignId('id_admin')->constrained('admins', 'id_admin')->cascadeOnDelete();
            $table->string('action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('produks');
        Schema::dropIfExists('websites');
        Schema::dropIfExists('templates');
        Schema::dropIfExists('admins');
    }
};
