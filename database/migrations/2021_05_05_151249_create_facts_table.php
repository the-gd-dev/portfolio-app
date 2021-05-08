<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         $fillable = [
            'user_id',
            'facts_overview',
            'fact', 
            'fact_value', 
            'fact_icon', 
        ];
        Schema::create('facts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->longText('facts_overview')->nullable();
            $table->string('fact')->nullable();
            $table->string('fact_value')->nullable();
            $table->string('fact_icon')->nullable();
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
        Schema::dropIfExists('facts');
    }
}
