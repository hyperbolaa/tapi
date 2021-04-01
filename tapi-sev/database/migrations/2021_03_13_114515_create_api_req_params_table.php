<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiReqParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_req_params', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aid')->comment('接口ID');
            $table->string('name')->comment('名称');
            $table->string('value')->nullable()->comment('值示例');
            $table->string('desc')->nullable()->comment('值描述');
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
        Schema::dropIfExists('api_req_params');
    }
}
