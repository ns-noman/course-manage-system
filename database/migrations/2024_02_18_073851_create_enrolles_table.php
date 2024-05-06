<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('enrolles', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->integer('trainee_id');
            $table->double('certificate_no');
            $table->date('enroll_date'); 
            $table->string('note'); 
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('enrolles');
    }
};