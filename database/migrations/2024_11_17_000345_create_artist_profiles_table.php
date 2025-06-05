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
    Schema::create('artist_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('username')->unique();
        $table->string('bio')->nullable();
        $table->string('hometown')->nullable();
        $table->string('profile_picture')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('artist_profiles');
}


};
