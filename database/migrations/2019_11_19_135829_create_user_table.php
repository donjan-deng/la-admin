<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sys_user', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('username', 50);
            $table->string('password', 100);
            $table->string('nick_name', 50)->comment('昵称');
            $table->string('real_name', 10)->comment('姓名');
            $table->tinyInteger('sex');
            $table->string('phone', 15);
            $table->string('email', 50);
            $table->string('union_id', 50)->comment('微信开放平台union_id');
            $table->string('open_id', 50)->comment('微信open_id');
            $table->string('avatar')->comment('头像');
            $table->timestamp('last_login_at')->nullable();
            $table->string('remember_token');
            $table->string('access_token', 100);
            $table->timestamp('access_token_expire_time')->nullable();
            $table->string('refresh_token', 100);
            $table->timestamp('refresh_token_expire_time')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
            $table->index('status');
            $table->unique('username');
            $table->unique('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sys_user');
    }

}
