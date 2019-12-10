<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId')->unsigned();
            $table->bigInteger('postId')->unsigned();
            $table->string("content");
            $table->timestamps();

            $table->foreign('userId')->references('id')->on('users')->
                onDelete("cascade")->onUpdate("cascade");

            $table->foreign('postId')->references('id')->on('posts')->
                onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
