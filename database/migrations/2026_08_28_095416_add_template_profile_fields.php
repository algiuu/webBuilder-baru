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
        Schema::table('websites', function (Blueprint $table): void {
            $table->string('nama_website')->after('id_template');
            $table->string('foto_pribadi')->nullable()->after('logo');
        });

        Schema::create('website_galleries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_website')->constrained('websites', 'id_website')->cascadeOnDelete();
            $table->string('foto');
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->timestamps();
        });

        Schema::create('website_contacts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('id_website')->constrained('websites', 'id_website')->cascadeOnDelete();
            $table->string('platform');
            $table->string('value');
            $table->timestamps();
            $table->unique(['id_website', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_contacts');
        Schema::dropIfExists('website_galleries');
        Schema::table('websites', function (Blueprint $table): void {
            $table->dropColumn(['nama_website', 'foto_pribadi']);
        });
    }
};
