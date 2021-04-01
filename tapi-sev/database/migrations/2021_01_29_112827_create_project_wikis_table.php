<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectWikisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_wikis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pid')->unique()->comment('项目ID,一个项目一个');
            $table->string('editor')->comment('编辑用户ID');
            $table->text('content')->comment('markdown内容');
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
        Schema::dropIfExists('project_wikis');
    }
}
