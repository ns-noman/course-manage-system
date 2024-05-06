<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('basic_infos', function (Blueprint $table) {
            $table->id();
            $table->string('title',50);
            $table->string('moto',255);
            $table->string('phone1',15);
            $table->string('phone2',15)->nullable();
            $table->string('email',50);
            $table->string('address',255);
            $table->string('logo',30);
            $table->string('favIcon',30);
            $table->string('currency_code',30);
            $table->string('currency_symbol',30);
            $table->string('acceptPaymentType',30);
            $table->string('copyRightName',500);
            $table->string('copyRightLink', 255)->default('#');
            $table->string('mapLink', 255)->default('#');
            $table->string('facebook', 255)->default('#');
            $table->string('instagram', 255)->default('#');
            $table->string('twitter', 255)->default('#');
            $table->string('pinterest', 255)->default('#');
            $table->string('linkedIn', 255)->default('#');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('basic_infos');
    }
};
