<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pid')->comment('项目ID');
            $table->bigInteger('cat_id')->comment('接口分类ID');
            $table->string('name')->comment('接口名称');
            $table->string('path')->comment('接口路径');
            $table->string('method')->default('GET')->comment('请求方式');
            $table->bigInteger('tag_id')->default(0)->comment('接口标签');
            $table->text('desc')->nullable()->comment('接口备注');
            $table->string('req_body_type')->default('none')->comment('内容类型,none,form,json');
            $table->string('res_body_type')->default('json')->comment('内容类型,json');
            $table->tinyInteger('status')->default(1)->comment('1:未完成，2:已完成');
            $table->string('creater')->comment('创建用户ID');
            $table->string('updater')->comment('编辑用户ID');
            $table->unique(['pid','path']);
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
        Schema::dropIfExists('apis');
    }
}
