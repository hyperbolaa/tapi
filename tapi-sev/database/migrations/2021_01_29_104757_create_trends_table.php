<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->comment('操作者用户ID');
            $table->string('username')->comment('操作者用户ID');
            $table->string('type')->comment('动态类型[team,project]');
            $table->bigInteger('type_id')->comment('动态类型对应的ID');
            $table->string('type_cat')->comment('动态类型对应的分类,比如api,cat,col');
            $table->text('content')->comment('操作内容');
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
        Schema::dropIfExists('trends');
    }
}
