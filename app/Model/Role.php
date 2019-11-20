<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    protected function getList($params, $pageSize)
    {
        if (!empty($params['with'])) {
            $query = $this->with($params['with']);
        } else {
            $query = $this->query();
        }
        if (!isset($params['sort_name']) || empty($params['sort_name'])) {
            $params['sort_name']=$this->primaryKey;
        }
        $params['sort_value'] = isset($params['sort_value'])?($params['sort_value'] == 'descend'?'desc':'asc'):'desc';
        $list = $query->orderBy($params['sort_name'], $params['sort_value'])->paginate($pageSize);
        return $list;
    }
}
