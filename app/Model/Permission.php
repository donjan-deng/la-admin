<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
    
    protected function getMenuList($parentId = 0, $isDisplay = 0, $permission = [])
    {
        $query = $this->where('parent_id', '=', $parentId);
        $isDisplay == 1 && $query->where('is_display', '=', 1);
        !empty($permission) && $query->whereIn('id', $permission);
        //dump($where);
        $result = $query->orderBy('sort', 'desc')->get();//->toSql();
        //dump($result);die();
        foreach ($result as &$value) {
            empty($value['alias']) && $value['alias'] = $value['name'];
            $value['child'] = $this->getMenuList($value['id'], $isDisplay, $permission);
        }
        return $result;
    }
}
