<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->integer('enrolle_id');
            $table->date('date');
            $table->tinyInteger('attendance_status');
            $table->string('comment');
            $table->tinyInteger('status');
            $table->tinyInteger('created_by_id');
            $table->tinyInteger('updated_by_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};