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
        Schema::create('phone_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->integer('rating');
            $table->text('review');
            $table->string('photo');
            $table->foreignId('phone_id')->constrained('phones')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phone_reviews');
    }
};
