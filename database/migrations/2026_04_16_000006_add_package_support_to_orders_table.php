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
        if (!Schema::hasTable('orders')) {
            return;
        }

        // Make product_id nullable and add package_id support.
        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
            });
        } catch (\Throwable $e) {
            // Ignore if foreign key already dropped/missing.
        }

        DB::statement('ALTER TABLE orders MODIFY product_id BIGINT UNSIGNED NULL');

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'package_id')) {
                $table->foreignId('package_id')->nullable()->after('product_id');
            }
        });

        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            });
        } catch (\Throwable $e) {
            // Ignore if already exists.
        }

        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('package_id')->references('id')->on('packages')->nullOnDelete();
            });
        } catch (\Throwable $e) {
            // Ignore if already exists.
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['package_id']);
            });
        } catch (\Throwable $e) {
        }

        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
            });
        } catch (\Throwable $e) {
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'package_id')) {
                $table->dropColumn('package_id');
            }
        });

        DB::statement('ALTER TABLE orders MODIFY product_id BIGINT UNSIGNED NOT NULL');

        try {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            });
        } catch (\Throwable $e) {
        }
    }
};

