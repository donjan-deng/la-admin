<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table((new Permission())->getTable())->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'is_display' => 1,
                'name' => 'manage',
                'display_name' => '后台管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'is_display' => 1,
                'name' => 'manage/auth',
                'display_name' => '系统管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 3,
                'parent_id' => 2,
                'is_display' => 1,
                'name' => 'manage/role/list',
                'display_name' => '角色管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 4,
                'parent_id' => 2,
                'is_display' => 1,
                'name' => 'manage/user/list',
                'display_name' => '用户管理',
                'guard_name' => 'web'
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'is_display' => 1,
                'name' => 'manage/config/list',
                'display_name' => '系统配置',
                'guard_name' => 'web'
            ],
            [
                'id' => 6,
                'parent_id' => 3,
                'is_display' => 0,
                'name' => 'manage/role/edit',
                'display_name' => '添加编辑角色',
                'guard_name' => 'web'
            ], [
                'id' => 7,
                'parent_id' => 3,
                'is_display' => 0,
                'name' => 'manage/role/attach',
                'display_name' => '分配权限',
                'guard_name' => 'web'
            ],
            [
                'id' => 8,
                'parent_id' => 4,
                'is_display' => 0,
                'name' => 'manage/user/edit',
                'display_name' => '添加编辑用户',
                'guard_name' => 'web'
            ], [
                'id' => 9,
                'parent_id' => 5,
                'is_display' => 0,
                'name' => 'manage/config/edit',
                'display_name' => '编辑配置',
                'guard_name' => 'web'
            ],
        ]);
    }

}
