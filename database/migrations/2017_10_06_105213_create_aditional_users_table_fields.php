<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAditionalUsersTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('address')->nullable();
            $table->integer('phone')->unsigned()->nullable();
            $table->string('institution')->nullable();
            $table->boolean('enabled')->default(true);
            $table->integer('teacher_id')->unsigned()->nullable()->after('id');
            $table->foreign('teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('teacher_id_foreign');
            $table->dropColumn(['dob', 'gender', 'address', 'phone', 'institution', 'enabled', 'teacher_id']);
        });
    }
}
