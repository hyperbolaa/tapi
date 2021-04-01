<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColCatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('col_cats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->comment('创建者');
            $table->bigInteger('pid')->comment('项目ID');
            $table->string('name')->comment('分类名称');
            $table->string('desc')->comment('分类简介');
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
        Schema::dropIfExists('col_cats');
    }
}
