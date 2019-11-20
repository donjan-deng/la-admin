<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Base extends Model {

    protected static $status = [
        0 => '禁用',
        1 => '正常'
    ];

    const STATUS_DELETED = -1; //status 为-1表示删除
    const STATUS_DISABLE = 0; //status 为0表示未启用
    const STATUS_ENABLE = 1; //status 为1表示正常

}
