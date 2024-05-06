<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('evaluation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('evaluation_id');
            $table->integer('enroll_id');
            $table->integer('obtain_marks');
            $table->string('remarks');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluation_details');
    }
};
