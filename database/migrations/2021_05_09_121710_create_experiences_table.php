<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('resume_id');
            $table->bigInteger('position_id')->nullable();
            $table->string('position')->nullable();
            $table->string('company_name')->nullable();
            $table->mediumText('company_address')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
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
        Schema::dropIfExists('experiences');
    }
}
