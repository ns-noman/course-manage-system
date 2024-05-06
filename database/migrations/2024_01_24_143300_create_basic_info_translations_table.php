<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('basic_info_translations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('basic_info_id')->unsigned();
            $table->string('locale')->index();
            
            $table->string('title',50);
            $table->string('moto',255);
            $table->string('address',255);

            $table->unique(['basic_info_id', 'locale']);
            $table->foreign('basic_info_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('basic_info_translations');
    }
};
