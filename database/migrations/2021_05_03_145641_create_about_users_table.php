<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            $table->string('email')->nullable();
            $table->string('about_image');
            $table->mediumText('about_summery')->nullable();
            $table->string('work_profiles');
            $table->mediumText('work_profiles_summery')->nullable();
            $table->mediumText('skills_summery')->nullable();
            $table->string('birthday');
            $table->string('age');
            $table->string('website')->nullable();
            $table->string('degree')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('freelancer')->nullable();
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
        Schema::dropIfExists('about_users');
    }
}
