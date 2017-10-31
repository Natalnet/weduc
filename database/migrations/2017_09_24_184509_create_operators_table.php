<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programming_language_id')->unsigned();
            $table->foreign('programming_language_id')
                  ->references('id')->on('programming_languages')
                  ->onDelete('cascade');
            $table->string('equals_to');
            $table->string('not_equal_to');
            $table->string('greater_than');
            $table->string('greater_than_or_equals_to');
            $table->string('less_than');
            $table->string('less_than_or_equals_to');
            $table->string('logical_and');
            $table->string('logical_or');
            $table->string('logical_not');
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
        Schema::dropIfExists('operators');
    }
}
