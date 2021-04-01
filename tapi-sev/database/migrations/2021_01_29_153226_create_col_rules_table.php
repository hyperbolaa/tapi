<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('col_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cat_id')->comment('案例分类ID');
            $table->tinyInteger('http_code')->default(0)->comment('检测返回状态码是否200[0:不检查，1:检查]');
            $table->tinyInteger('response_schema')->default(0)->comment('检查返回数据结构[0:不检查，1:检查]');
            $table->tinyInteger('response_field_check')->default(0)->comment('检查返回字段[0:不检查，1:检查]');
            $table->string('response_field_name')->nullable()->comment('返回字段名称');
            $table->string('response_field_value')->nullable()->comment('返回字段值');
            $table->text('report')->nullable()->comment('测试报告');
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
        Schema::dropIfExists('col_rules');
    }
}
