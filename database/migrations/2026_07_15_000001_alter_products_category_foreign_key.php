<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['cateid']);
        });

        DB::statement('ALTER TABLE products MODIFY cateid INT UNSIGNED NULL');

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('cateid')
                ->references('cateid')
                ->on('categories')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['cateid']);
        });

        DB::statement('ALTER TABLE products MODIFY cateid INT UNSIGNED NOT NULL');

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('cateid')
                ->references('cateid')
                ->on('categories')
                ->restrictOnDelete();
        });
    }
};
