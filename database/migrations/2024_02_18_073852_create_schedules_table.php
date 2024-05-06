<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('week_days');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};