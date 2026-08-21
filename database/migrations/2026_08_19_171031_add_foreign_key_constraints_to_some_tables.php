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
        Schema::table('product_variants', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->restrictOnDelete();
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->cascadeOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->restrictOnDelete();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->restrictOnDelete();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_variant_id')
                ->references('id')
                ->on('product_variants')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table): void {
            $table->dropForeign(['product_id']);
        });

        Schema::table('carts', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
        });

        Schema::table('cart_items', function (Blueprint $table): void {
            $table->dropForeign(['cart_id']);
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->dropForeign(['user_id']);
        });

        Schema::table('order_items', function (Blueprint $table): void {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_variant_id']);
        });
    }
};
