<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_follow', function (Blueprint $table) {
            $table->id();
            $table->integer('user1_id')->unsigned()->nullable(); //user follow
            $table->integer('user2_id')->unsigned()->nullable(); //user được follow
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
        Schema::dropIfExists('ml_follow');
    }
}
