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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('order_code');
            $table->unsignedBigInteger('total_amount');
            $table->unsignedBigInteger('tax_amount');
            $table->text('shipping_address');
            $table->string('city');
            $table->string('post_code');
            $table->boolean('is_paid');
            $table->string('payment_proof');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
