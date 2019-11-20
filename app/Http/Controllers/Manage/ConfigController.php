<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Model;
use App\Http\Requests\Manage;
use App\Helpers\Code;

class ConfigController extends BaseController
{
    public function getList(Request $request)
    {
        $params = $request->all();
        $pageSize = $request->input('per_page', 15);
        $list = Model\Config::getList($params, $pageSize);
        return $this->json(success($list));
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $model = Model\Config::find($data['key']);
        if ($model) {
            $model->description = $data['description'];
            $model->value = $data['value'];
            $model->save();
        }
        return $this->json(success($model));
    }
}
