<?php

namespace App\Http\Controllers\Home\Test;


use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

use App\Http\Controllers\Home\Test\Test;


class TestRequest extends HomeController
{
    static public  function store($data = [])
    {
        $rules = [
            'userName'    => 'required|email|max:25',
            'passWord'   => 'required|between:6,25',
            // 'name'  => 'sometimes|max:20',  //sometimes的用意（不传则已，传则必须遵守规则）
        ];

        $messages = [
            'required'  => ':attribute不能为空',
            'max'       => ':attribute长度 不能大于 :max 位',
            'between'   => ':attribute长度 应在 6位 与25位之间'
        ];

        $attributes = [
            'userName'    => '用户名',
            'passWord'   => '密码',

        ];

        $validator = \Validator::make($data, $rules, $messages, $attributes);
        if ($validator->fails()) {
            //显示所有错误组成的数组

            $result['first'] = $validator->errors()->first();
            $result['all'] = $validator->errors()->all();
            return $result;
            //return $validator->errors()->first();     //显示第一条错误
        }


    }


}
