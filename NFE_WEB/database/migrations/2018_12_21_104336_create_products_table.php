<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('ncm');
            $table->unsignedInteger('cfop');
            $table->string('unit');
            $table->decimal('value', 9, 2);
            $table->decimal('price', 9, 2);
            $table->decimal('aliquota', 9, 2);
            $table->decimal('ipi', 9, 2);
            $table->string('photo')->nullable();
            $table->string('photo_mini')->nullable();
            $table->unsignedInteger('enterprise');
            $table->foreign('ncm')->references('id')->on('ncms')->onDelete('cascade');
            $table->foreign('cfop')->references('id')->on('cfops')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
