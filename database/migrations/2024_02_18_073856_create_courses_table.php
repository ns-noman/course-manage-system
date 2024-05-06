<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {


            // Title of the course
            // Duration of the course (hours: 20)
            // Number of Class (10)
            // Per class duration (hours:2)
            // Class per weeks (2)
            // Objective of the course
            // Benefits of the course
            // Training Methodology 
            // Short syllabus ( upload doc) / text filed having 4000char
            // Contents Description: ( long text having multiple add button)
            // Entry date
            // Entry by
            // Last modification date



            $table->id();
            $table->string('title');
            $table->integer('total_duration');
            $table->integer('per_class_duration');
            $table->integer('total_class');
            $table->string('class_per_week');
            $table->text('objective');
            $table->text('methodology');
            $table->text('benifits');
            $table->text('short_syllabus');
            $table->longText('description');
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by_id')->nullable();
            $table->integer('updated_by_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};