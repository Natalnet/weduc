<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgrammingLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programming_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->text('description');
            $table->string('robot');
            $table->string('call_function');
            $table->string('compile_code');
            $table->string('compiler_file');
            $table->string('extension');
            $table->text('header')->nullable();
            $table->text('footer')->nullable();
            $table->string('main_function');
            $table->string('other_functions');
            $table->string('send_code');
            $table->string('sent_extension');
            $table->boolean('is_private');
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
        Schema::dropIfExists('programming_languages');
    }
}
