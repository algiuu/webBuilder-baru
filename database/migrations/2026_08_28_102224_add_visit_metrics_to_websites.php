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
            $table->unsignedBigInteger('visit_count')->default(0)->after('status');
            $table->timestamp('last_visited_at')->nullable()->after('visit_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table): void {
            $table->dropColumn(['visit_count', 'last_visited_at']);
        });
    }
};
