<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCommissionRequestsTableForPriceAndDeliveredStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_requests', function (Blueprint $table) {
            // Adding 'price' column (nullable)
            $table->decimal('price', 8, 2)->nullable()->after('status');

            // Modifying the 'status' column to include a new 'delivered' status
            $table->enum('status', ['pending', 'approved', 'rejected', 'ready', 'delivered'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_requests', function (Blueprint $table) {
            // Dropping the 'price' column
            $table->dropColumn('price');

            // Reverting the 'status' column to its previous state
            $table->enum('status', ['pending', 'approved', 'rejected', 'ready'])->default('pending')->change();
        });
    }
}
