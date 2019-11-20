<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        App\Model\User::create([
            'username' => 'admin',
            'password' => bcrypt('123456'),
            'nick_name' => '超级管理员',
            'real_name' => '超级管理员',
            'status' => 1
        ]);
    }

}
