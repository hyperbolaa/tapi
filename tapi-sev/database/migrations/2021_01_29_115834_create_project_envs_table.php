<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectEnvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_envs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pid')->comment('项目ID');
            $table->string('name')->default('local')->comment('环境名称');
            $table->string('protocol')->default('http://')->comment('环境协议');
            $table->string('domain')->default('127.0.0.1')->comment('环境域名');
            $table->text('header')->nullable()->comment('header,数组json处理');
            $table->text('cookie')->nullable()->comment('cookie,数组json处理');
            $table->text('global')->nullable()->comment('global,数组json处理');
            $table->unique(['pid','name']);
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
        Schema::dropIfExists('project_envs');
    }
}
