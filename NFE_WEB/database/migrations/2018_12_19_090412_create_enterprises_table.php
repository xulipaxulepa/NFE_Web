<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('social_name')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('tax_regime')->nullable();
            $table->string('state_registration')->nullable();
            $table->string('legal_nature')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('place')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('district')->nullable();
            $table->string('code_city')->nullable();
            $table->string('city')->nullable();
            $table->string('code_state')->nullable();
            $table->string('state')->nullable();
            $table->string('certified')->nullable();
            $table->string('password_certified')->nullable();
            $table->string('photo')->nullable();
            $table->string('photo_mini')->nullable();
            $table->unsignedInteger('user');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('enterprises');
    }
}
