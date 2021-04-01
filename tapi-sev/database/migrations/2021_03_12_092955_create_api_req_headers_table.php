<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiReqHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_req_headers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('aid')->comment('接口ID');
            $table->string('name')->comment('名称');
            $table->string('value')->comment('值');
            $table->string('desc')->nullable()->comment('值描述');
            $table->tinyInteger('sort')->default(0)->comment('值排序,正序');
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
        Schema::dropIfExists('api_req_headers');
    }
}
