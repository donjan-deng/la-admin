<?php

namespace App\Http\Resources;

class Users extends Collection
{
    public $collects = 'App\Http\Resources\User';
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
