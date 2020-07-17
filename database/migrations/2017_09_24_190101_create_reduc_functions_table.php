<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reduc_functions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programming_language_id')->unsigned();
            $table->foreign('programming_language_id')
                  ->references('id')->on('programming_languages')
                  ->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->string('target_description')->nullable();
            $table->string('type');
            $table->string('return_type');
            $table->tinyInteger('parameters')->unsigned();
            $table->text('code');
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
        Schema::dropIfExists('functions');
    }
}
