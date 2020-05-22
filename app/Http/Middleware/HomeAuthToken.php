<?php
/**
 * 接口的 token 认证
 */
namespace App\Http\Middleware;

use App\Http\Controllers\Home\User\User;
use Closure;
use Illuminate\Support\Facades\Redis;
use Jsyqw\Utils\Results;

class HomeAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('api-token');
        if(!$token){
            $token = $request->get('api-token');
        }
        $result = new Results();
        if(!$token){
            return $result->authError('认证错误');
        }
        if(!Redis::exists($token))
        {
            return $result->authError('认证已经失效，请重新登录');

        }

        $userInfo = User::where('token',$token)->first();
        // //账号状态 -1:刪除 1:正常 2:禁止登陆
        if(-1 == $userInfo['status']){
            return $result->error('账号已删除！');
        }
        if(2 == $userInfo['status']){
            return $result->error('该账号被禁止登陆！');
        }
        $params = ['user' => $userInfo];


        $request->attributes->add($params);//添加参数 $request->get('mid_userInfo');

        return $next($request);
    }
}
