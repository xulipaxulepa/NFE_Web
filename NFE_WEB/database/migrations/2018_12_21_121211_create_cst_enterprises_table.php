<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCstEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cst_enterprises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('description')->nullable();
            $table->boolean('status');
            $table->unsignedInteger('cst');
            $table->unsignedInteger('enterprise');
            $table->foreign('cst')->references('id')->on('csts')->onDelete('cascade');
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
        Schema::dropIfExists('cst_enterprises');
    }
}
