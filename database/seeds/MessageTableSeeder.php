<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Model\Message;

class MessageTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table((new Message())->getTable())->insert([
            [
                'id' => 200,
                'type' => 1,
                'message' => 'success'
            ],
            [
                'id' => 401,
                'type' => 1,
                'message' => '登录失效或者未登录，请先登录！'
            ],
            [
                'id' => 403,
                'type' => 1,
                'message' => '无权进行该操作'
            ],
            [
                'id' => 404,
                'type' => 1,
                'message' => '未找到该信息'
            ],
            [
                'id' => 1001,
                'type' => 1,
                'message' => '保存数据失败'
            ],
            [
                'id' => 1002,
                'type' => 1,
                'message' => '数据库查询错误'
            ],
            [
                'id' => 1003,
                'type' => 1,
                'message' => '用户名或者密码错误'
            ]
        ]);
    }

}
