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
    Schema::table('commission_requests', function (Blueprint $table) {
        $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
    });
}

public function down()
{
    Schema::table('commission_requests', function (Blueprint $table) {
        $table->dropColumn('payment_status');
    });
}

};
