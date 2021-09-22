<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifyBoolToIps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ips', function (Blueprint $table) {
            $table->dropColumn('linenotifytoken_id');
            $table->boolean('linenotify')->default(true);
            $table->boolean('webnotify')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ips', function (Blueprint $table) {
            $table->foreignId('linenotifytoken_id');
            $table->dropColumn('linenotify');
            $table->dropColumn('webnotify');
        });
    }
}
