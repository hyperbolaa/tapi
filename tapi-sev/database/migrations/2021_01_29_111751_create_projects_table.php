<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->comment('用户ID');
            $table->bigInteger('tid')->comment('团队ID');
            $table->string('name')->comment('项目名称');
            $table->string('desc')->nullable()->comment('项目简介');
            $table->string('path')->nullable()->comment('基础路径');
            $table->string('token')->nullable()->comment('基础路径');
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
        Schema::dropIfExists('projects');
    }
}
