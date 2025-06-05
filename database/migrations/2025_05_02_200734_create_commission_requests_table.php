<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('commission_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('artist_id');
        $table->unsignedBigInteger('customer_id');
        $table->string('canvas_size');
        $table->text('description')->nullable();
        $table->string('status')->default('pending'); // pending, accepted, rejected
        $table->timestamps();

        $table->foreign('artist_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_requests');
    }
};
