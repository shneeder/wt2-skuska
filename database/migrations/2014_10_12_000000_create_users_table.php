<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->string('first_name')->default("");
            $table->string('last_name')->default("");
            $table->string('street')->default("");
            $table->string('postal_code')->default("");
            $table->string('town')->default("");
            $table->float('latitude')->default(0);
            $table->float('longtitude')->default(0);
            $table->string('school_name')->default("");
            $table->string('school_address')->default("");
            $table->float('school_lat')->default(0);
            $table->float('school_lng')->default(0);
            $table->boolean('isAdmin')->default(false);
            $table->boolean('verified')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
