<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStuIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('stu_id', 15)->after('id');
            $table->string('nickname', 50)->after('name');
            $table->enum('sex', ['男', '女', '其他'])->after('name');
            // $table->string('sex', 5)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stu_id');
            $table->dropColumn('nickname');
            $table->dropColumn('sex');
        });
    }
}
