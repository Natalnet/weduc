<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programming_language_id')->unsigned();
            $table->foreign('programming_language_id')
                  ->references('id')->on('programming_languages')
                  ->onDelete('cascade');
            $table->string('break_code');
            $table->string('do_code');
            $table->string('for_code');
            $table->string('if_code');
            $table->string('repeat_code');
            $table->string('switch_code');
            $table->string('while_code');
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
        Schema::dropIfExists('control_flows');
    }
}
