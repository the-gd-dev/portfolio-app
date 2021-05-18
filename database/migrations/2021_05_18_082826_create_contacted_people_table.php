<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactedPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacted_people', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('recipient');
            $table->string('secret_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message')->nullable();
            $table->enum('email_recieved',[0,1])->comment('1 for recieved, 0 for not recieved')->default(0);
            $table->enum('email_checked',[0,1])->comment('1 for checked, 0 for not checked')->default(0);
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
        Schema::dropIfExists('contacted_people');
    }
}
