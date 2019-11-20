<?php

namespace App\Model;

class Config extends Base
{
    protected $table = 'sys_config';
    protected $guarded = [];
    protected $primaryKey = 'key';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    //$type = ['integer', 'string', 'array','float','boolean','json'];

    protected $casts = [
        'value' => 'json',
    ];

    public function getValueTextAttribute()
    {
        return $this->attributes['value_text'] = $this->getValue($this->attributes['type'], $this->attributes['value']);
    }

    protected function getList($params, $pageSize)
    {
        $query = $this->query();
        if (!isset($params['sort_name']) || empty($params['sort_name'])) {
            $params['sort_name']=$this->primaryKey;
        }
        $params['sort_value'] = isset($params['sort_value'])?($params['sort_value'] == 'descend'?'desc':'asc'):'desc';
        $list = $query->orderBy($params['sort_name'], $params['sort_value'])->paginate($pageSize);
        foreach ($list as &$value) {
            $value->value_text;
        }
        return $list;
    }
    protected function G($key)
    {
        $model = $this->find($key);
        if ($model) {
            return $this->getValue($model->type, $model->value);
        }
        return null;
    }
    protected function getValue($type, $value)
    {
        switch ($type) {
            case 'integer':
                $value = str_replace('"', '', $value);
                return intval($value);
            case 'float':
                $value = str_replace('"', '', $value);
                return floatval($value);
            case 'boolean':
                $value = str_replace('"', '', $value);
                return ((bool) $value);
            case 'string':
                $value = str_replace('"', '', $value);
                return $value;
            default:
                return $value;
        }
    }
}
