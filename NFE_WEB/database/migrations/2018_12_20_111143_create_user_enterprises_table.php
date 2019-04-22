<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_enterprises', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user');
            $table->unsignedInteger('enterprise');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('enterprise')->references('id')->on('enterprises')->onDelete('cascade');
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
        Schema::dropIfExists('user_enterprises');
    }
}
