<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify ENUM to include 'admin'
        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'artist', 'admin') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        // Revert back to original ENUM (without 'admin')
        DB::statement("ALTER TABLE users MODIFY role ENUM('customer', 'artist') NOT NULL DEFAULT 'customer'");
    }
};
