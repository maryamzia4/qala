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
    Schema::table('commission_requests', function (Blueprint $table) {
        $table->string('name')->after('customer_id');
        $table->string('email')->after('name');
        $table->string('title')->after('email');
        $table->date('deadline')->nullable()->after('description');
        $table->string('budget')->nullable()->after('deadline');
        $table->string('delivery_type')->default('digital')->after('budget'); // digital, physical, both
        $table->json('reference_images')->nullable()->after('delivery_type');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('commission_requests', function (Blueprint $table) {
        $table->dropColumn([
            'name',
            'email',
            'title',
            'deadline',
            'budget',
            'delivery_type',
            'reference_images'
        ]);
    });
}

};
