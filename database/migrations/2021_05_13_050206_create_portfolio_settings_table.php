<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolioSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('setting')->nullable();
            $table->string('value')->nullable();
            $table->enum('is_apply',[0,1])->comment('1 for active, 0 for inactive')->default(1);
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
        Schema::dropIfExists('portfolio_settings');
    }
}
