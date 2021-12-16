<?php

use Encore\Admin\Form\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('serial_No',30);
            $table->string('curriculum_No',30);
            $table->string('name',255);
            $table->string('ename',255);
            $table->string('class',30);
            $table->string('team',10)->nullable();
            $table->string('type',30);
            $table->string('etype',30);
            $table->integer('time')->default(0);
            $table->integer('practice')->default(0);
            $table->integer('point')->default(0);
            $table->string('week',5)->nullable();
            $table->string('schedule',30)->nullable();
            $table->string('location',30)->nullable();
            $table->string('max',30)->nullable();
            $table->text('remarks')->nullable();
            $table->string('teacher', 255)->nullable()->default('');
            // $table->foreignId('teacher_id');
            $table->foreignId('semester_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
