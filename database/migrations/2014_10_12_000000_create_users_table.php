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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street');
            $table->string('postal_code');
            $table->string('town');
            $table->float('latitude', 11, 2);
            $table->float('longtitude', 11, 2);
            $table->string('school_name');
            $table->string('school_address');
            $table->float('school_lat', 11, 2);
            $table->float('school_lng', 11, 2);
            $table->boolean('isAdmin')->default(false);
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
