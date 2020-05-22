<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     public function success_($data = [],$message = '')
    {
    	return response()->json([
    		'status' => 'success',
    		'code' => 0,
    		'message' =>  $message,
    		'data' => $data,
    		'time' => date("Y-m-d H:i:s"),
    		'url' =>  \Request::getRequestUri(),

    	]);
    }

    public function fail_($data = [],$message = '请求失败')
    {
     	return response()->json([
    		'status' => 'error',
    		'code' => 1,
    		'message' => $message,
    		'data' => $data,
    		'time' => date("Y-m-d H:i:s"),
    		'url' =>  \Request::getRequestUri(),

    	]);
    }
}
