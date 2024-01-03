<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string("avatar",500)->nullable();
            $table->string("address",100)->nullable();
            $table->string("number_phone",100)->nullable();
            $table->integer("sex")->unsigned()->nullable();
            $table->integer("status")->comment('0. tài khoản bình thường - 1. tài khoản khóa tạm thời -2. Tài khoản khó vĩnh viễn')->default(0);
            $table->string("content_status",100)->nullable();
            $table->integer("role")->unsigned()->comment('1. tài khoản admin - 0. tài khoản user');
            $table->tinyInteger('active_status')->comment('Trạng thái hoạt động (on-off)')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
