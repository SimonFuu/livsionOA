<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_users', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('username', 255)->comment('用户名');
            $table->string('password', 255)->comment('密码');
            $table->string('name', 255)->comment('姓名');
            $table->unsignedTinyInteger('gender', false)->default(1)->comment('性别：1-男，2-女');
            $table->string('email', 255)->comment('邮箱地址')->nullable();
            $table->string('telephone', 255)->comment('电话号码')->nullable();
            $table->string('officeTel', 255)->comment('办公电话')->nullable();
            $table->string('avatar', 255)->comment('头像')->default('/files/images/users/avatar/default.jpg');
            $table->dateTime('birthday')->comment('出生日期')->default('1990-01-01 00:00:00');
            $table->unsignedTinyInteger('isAdmin', false)->default(0)->comment('是否是后台管理员：0-否，1-是');
            $table->integer('weight', false, true)->default(1000)
                ->comment('显示权重，值越小越靠前');
            $table->rememberToken();
            $table->dateTime('addTime')->comment('创建时间')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('updateTime')
                ->comment('修改时间')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unsignedTinyInteger('isDelete', false)->default(0)->comment('是否删除：0-否，1-是');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_users');
    }
}
