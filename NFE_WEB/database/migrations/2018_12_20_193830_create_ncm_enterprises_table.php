<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNcmEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncm_enterprises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('description')->nullable();
            $table->decimal('ipi', 9, 2)->nullable();
            $table->boolean('status');
            $table->unsignedInteger('ncm');
            $table->unsignedInteger('enterprise');
            $table->foreign('ncm')->references('id')->on('ncms')->onDelete('cascade');
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
        Schema::dropIfExists('ncm_enterprises');
    }
}
