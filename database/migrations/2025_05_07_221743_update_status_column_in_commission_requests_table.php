<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInCommissionRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('commission_requests', function (Blueprint $table) {
            // You can use enum if you want to strictly enforce valid values
            $table->enum('status', ['pending', 'approved', 'rejected', 'ready'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('commission_requests', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
        });
    }
}
