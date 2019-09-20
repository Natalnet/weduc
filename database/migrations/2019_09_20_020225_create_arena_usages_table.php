<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArenaUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arena_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('arena_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('points')->default(0);
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
        Schema::dropIfExists('arena_usages');
    }
}
