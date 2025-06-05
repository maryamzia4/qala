<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneAndAddressToCommissionRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('commission_requests', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
        });
    }

    public function down()
    {
        Schema::table('commission_requests', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address']);
        });
    }
}
