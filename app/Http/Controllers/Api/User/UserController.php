<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends BaseController
{


	public function login(Request $request)
	{


	}

	// 获取登录用户列表
	public function onlineUserList(Request $request)
	{
		// $status = Redis::lpush("token",str_random(40));
		// $res_num = Redis::sadd('token',str_random(40));
		$countList = Redis::llen('token');
		$page = $request->get('currentPage') - 1;
		$pageSize = $request->get('pageSize');
		// DD($countList);
		$tokenList = Redis::lrange('token',$page *$pageSize   ,$page *$pageSize + $pageSize -1 );
		$data['countList'] = $countList;
		foreach ($tokenList as $key => $value) 
		{
			$user = User::where('token',$value)->first();
			if($user)
			{
				$data['data'][] = $user;
			}
		}

		return $this->success_($data);
	}

	// 强退登录用户
	public function logoutHomeOnlineUser(Request $request)
	{
		$id = $request->get('id');
		$userInfo = User::find($id);
		if(!$userInfo)
		{
			return $this->fail_('',500003);
		}
		$status = Redis::lrem('token', $userInfo->id,$userInfo->token);
		if($status)
		{
			$userInfo->update(['token' => '']);
			return $this->success_();
		}
		else
		{
			return $this->fail_('',500001);
		}
	}



	// 获取用户列表
	public function HomeUserList(Request $request)
	{

		$pageSize = $request->get('pageSize');


		$userList = User::where(['status' => 1])->paginate($pageSize);



		return $this->success_($userList);
		DD($userList);
		DD($request->all());
	}


	// 修改用户信息
	public function editHomeUserList(Request $request)
	{

		$id = $request->get('id');
		$user = User::find($id);
        if(!$user)
        {
            return $this->fail_();
        }
        $user->update($request->all());


		return $this->success_($user);

	}

	// 修改密码

	public function editHomeUserPass(Request $request)
	{

		$id = $request->get('id');
        $password = $request->get('password');
        if (!$id || !$password) {
            return $this->fail_('',500004);
        }
        $model = User::find($id);
        if (!$model) {
            return $this->fail_('','用户不存在');
        }

        $model->password = md5(md5($password));

        $ret = $model->save();
        if (!$ret) {
            return $this->fail_('','修改密码失败');
        }
        return $this->success_();


	}

	public function deleteHomeUserList(Request $request)
	{
		$id = $request->get('id');
        if (!$id) {
            return $this->fail_('','参数有误');
        }
 
        $model = User::find($id);
        if (!$model) {
            return $this->fail_('','用户不存在');
        }
        //删除状态
        $model->status = -1;
        // $model->update_time = time();
        $ret = $model->save();
        if (!$ret) {
            return $this->fail_('','删除失败');
        }
        return $this->success_('','删除成功');
	}




}
