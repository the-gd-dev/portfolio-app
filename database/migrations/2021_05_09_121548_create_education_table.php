<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('resume_id');
            $table->bigInteger('course_id')->nullable();
            $table->string('course')->nullable();
            $table->bigInteger('institute_id')->nullable();
            $table->string('institute')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->longText('course_description')->nullable();
            $table->enum('is_shown', [0,1])->comment('"0" for No "1" for Yes ')->default(1);
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
        Schema::dropIfExists('education');
    }
}
