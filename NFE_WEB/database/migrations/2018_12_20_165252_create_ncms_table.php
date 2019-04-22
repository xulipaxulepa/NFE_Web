<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNcmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('description')->nullable();
            $table->decimal('ipi', 9, 2)->nullable();
            $table->boolean('main');
            $table->string('access')->nullable();
            $table->string('modify')->nullable();
            $table->string('destroy')->nullable();
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
        Schema::dropIfExists('ncms');
    }
}
