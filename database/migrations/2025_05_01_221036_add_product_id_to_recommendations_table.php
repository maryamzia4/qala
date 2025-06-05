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
    Schema::table('recommendations', function (Blueprint $table) {
        $table->integer('product_id')->after('user_id');  // Add the product_id column
    });
}

public function down()
{
    Schema::table('recommendations', function (Blueprint $table) {
        $table->dropColumn('product_id');
    });
}

};
