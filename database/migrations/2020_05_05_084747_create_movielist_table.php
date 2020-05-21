<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovielistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movielist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('taglist')->nullable();  // タグ、キーワード
            $table->string('listname')->nullable();  // 動画リスト名
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
        Schema::dropIfExists('movielist');
    }
}
