<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("activity_type");
            $table->string("content");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("post_id");
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->
            onDelete("cascade")->onUpdate("cascade");

            $table->foreign('post_id')->references('id')->on('posts')->
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
        Schema::dropIfExists('activities');
    }
}
