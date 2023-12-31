<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlDiarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_diarys', function (Blueprint $table) {
            $table->id();
            $table->string('title',500)->nullable();
            $table->text('description')->nullable();
            $table->json('hashtags')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->tinyInteger('status')->default(1)->comment('1. công khai - 2. Chỉ mình tôi - 3. chỉ những người theo dõi tôi');
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
        Schema::dropIfExists('ml_diarys');
    }
}
