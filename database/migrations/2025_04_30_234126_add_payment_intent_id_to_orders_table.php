<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up()
{
Schema::table('orders', function (Blueprint $table) {
$table->string('payment_intent_id')->nullable()->after('total_price');
});
}

public function down()
{
Schema::table('orders', function (Blueprint $table) {
$table->dropColumn('payment_intent_id');
});
}
};