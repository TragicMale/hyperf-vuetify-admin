<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $blueprint) {
            $blueprint->integerIncrements('id');
            $blueprint->string('username', 16);
            $blueprint->string('password', 64);
            $blueprint->tinyInteger('state')->default(0)->comment('1:启用，0：未启用');
            $blueprint->timestamps();
            $blueprint->softDeletes();
        });

        Schema::create('role', function (Blueprint $blueprint) {
            $blueprint->integerIncrements('id');
            $blueprint->string('name', 24);
            $blueprint->string('key', 24);
            $blueprint->string('remark', 32)->default('');
            $blueprint->tinyInteger('state')->default(0)->comment('1:启用，0：未启用');
            $blueprint->timestamps();
        });

        Schema::create('menu', function (Blueprint $blueprint) {
            $blueprint->integerIncrements('id');
            $blueprint->integer('pid')->default(0);
            $blueprint->tinyInteger('seq')->default(99)->comment('排序');
            $blueprint->string('name', 24);
            $blueprint->tinyInteger('type')->default(1)->comment('1：菜单，2：按钮');
            $blueprint->string('path', 32)->default('')->comment('前端路由路径 或者 url');
            $blueprint->string('icon', 16)->default('')->comment('只支持 mdi icon');
            $blueprint->tinyInteger('state')->default(0)->comment('1:启用，0：未启用');
            $blueprint->timestamps();
        });

        Schema::create('role_menu', function (Blueprint $blueprint) {
            $blueprint->integerIncrements('id');
            $blueprint->integer('role_id')->comment('角色ID');
            $blueprint->integer('menu_id')->comment('菜单ID');
            $blueprint->integer('is_dir')->default(0)->comment('是否目录节点');
            $blueprint->timestamps();
        });

        Schema::create('resource', function (Blueprint $blueprint) {
            $blueprint->integerIncrements('id');
            $blueprint->string('path', 64)->comment('资源路径');
            $blueprint->string('action', 12)->comment('操作');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
