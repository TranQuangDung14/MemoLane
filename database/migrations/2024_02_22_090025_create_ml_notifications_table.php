<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user1_id')->unsigned()->nullable()->comment('user tạo tương tác'); //user tạo tương tác
            $table->integer('user2_id')->unsigned()->nullable()->comment('user được tương tác'); //user được tương tác
            $table->integer('diary_id')->unsigned()->nullable();//check lại
            $table->integer('event_id')->unsigned()->nullable();// sẽ ăn theo type
            $table->tinyInteger('type')->nullable()->comment('0. thông báo like - 1. thông báo follow - 2. thông báo comment');
            $table->tinyInteger('read')->default(0)->comment('0. chưa đọc - 1. đã đọc');
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
        Schema::dropIfExists('ml_notifications');
    }
}
