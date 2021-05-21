<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('secret_id')->nullable()->after('role_id');
            $table->string('google_id')->nullable()->after('secret_id');
            $table->string('facebook_id')->nullable()->after('google_id'); 
            $table->string('linkedin_id')->nullable()->after('facebook_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIfExists(['secret_id','google_id', 'facebook_id', 'linkedin_id']);
        });
    }
}
