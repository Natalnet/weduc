<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programming_language_id')->unsigned();
            $table->foreign('programming_language_id')
                  ->references('id')->on('programming_languages')
                  ->onDelete('cascade');
            $table->string('declare_string');
            $table->string('declare_float');
            $table->string('declare_boolean');
            $table->string('declare_true');
            $table->string('declare_false');

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
        Schema::dropIfExists('data_types');
    }
}
