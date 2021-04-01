<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiReqBodyJsonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_req_body_jsons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aid')->comment('接口ID');
            $table->bigInteger('fid')->default(0)->comment('父ID，存在递归');
            $table->string('name')->comment('名称');
            $table->tinyInteger('required')->default(1)->comment('是否必须,1:必须，2：非必须');
            $table->string('datatype')->default('string')->comment('值类型');
            $table->string('value')->nullable()->comment('值示例');
            $table->string('desc')->nullable()->comment('值描述');
            $table->tinyInteger('sort')->default(1)->comment('值排序,正序');
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
        Schema::dropIfExists('api_req_body_jsons');
    }
}
