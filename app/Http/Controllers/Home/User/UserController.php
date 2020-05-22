<?php

namespace App\Http\Controllers\Home\User;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\Home\User\User;
use App\Http\Controllers\Home\User\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class UserController extends HomeController
{
    public function index(Request $request)
    {
        $user = $request->get('user');
        // 分页
        $users = User::simplePaginate(12);

        return $this->success($users,900001);
    }

    public function store(Request $request)
    {

        $result = UserRequest::store($request->all());
        if($result)
        {
            return $this->fail($result,500004);
        }
        $request['passWord'] = md5(md5($request->get('passWord')));
        $request['avatar'] = 'http://att3.citysbs.com/200x200/hangzhou/2020/04/15/11/dd6719bd4287d9efd49434c43563a032_v2_.jpg';
        $user = User::create($request->all());

        return $this->success($user,900002);
    }

    public function show($id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->fail($user);
        }

        return $this->success($user,900001);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return $this->fail($user);
        }
        $user->update($request->all());

        return $this->success($user,900003);
    }

    public function destroy($id)
    {
        $result = User::destroy($id);

        return $this->success($result,900004);
    }

    public function login(Request $request)
    {

        $user = $request->all();
        // 字段验证
        $result = UserRequest::login($user);

        if($result)
        {
            return $this->fail($result,500004);
        }

        $isUser = User::where(['username' => $user['userName'] ])->first();

        if($result)
        {
            return $this->fail($result,800001);
        }
        if(md5(md5($user['passWord']))  != $isUser->password)
        {
            return $this->fail($result,800002);
        }

        $isUser->update(['token' => bcrypt(str_random(40)),'last_login_time' => time()]);
        // 存入Redis，过期时间一天
        Redis::setex($isUser->token , 86400, $isUser->id );

        return $this->success($isUser);


    }
















}
