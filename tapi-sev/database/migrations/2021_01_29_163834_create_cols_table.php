<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->comment('创建用户ID');
            $table->bigInteger('pid')->comment('项目ID');
            $table->bigInteger('cat_id')->comment('案例分类ID');
            $table->bigInteger('api_id')->comment('接口ID');
            $table->string('name')->comment('案例名称');
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
        Schema::dropIfExists('cols');
    }
}
