<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid',50)->unique()->comment('用户ID');
            $table->string('email',100)->unique()->comment('用户邮箱');
            $table->string('name',100)->comment('用户姓名');
            $table->string('password',100)->comment('用户密码');
            $table->string('avatar',300)->nullable()->comment('用户头像');
            $table->string('role',50)->default('member')->comment('用户角色[admin,member]');
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
        Schema::dropIfExists('users');
    }
}
