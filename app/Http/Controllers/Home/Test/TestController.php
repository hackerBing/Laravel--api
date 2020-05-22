<?php

namespace App\Http\Controllers\Home\Test;


use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

use App\Http\Controllers\Home\Test\Test;


class TestController extends HomeController
{
    public function index()
    {
        // 分页
        $tests = Test::simplePaginate(12);

        return $this->success($tests,900001);
    }

    public function store(Request $request)
    {

        $result = TestRequest::store($request->all());
        if($result)
        {
            return $this->fail($result,500004);
        }
        $test = Test::create($request->all());

        return $this->success($test,900002);
    }

    public function show($id)
    {
        $test = Test::find($id);
        if(!$test)
        {
            return $this->fail($test);
        }

        return $this->success($test,900001);
    }

    public function update(Request $request, $id)
    {
        $test = Test::find($id);
        if(!$test)
        {
            return $this->fail($test);
        }
        $test->update($request->all());

        return $this->success($test,900003);
    }

    public function destroy($id)
    {
        $result = Test::destroy($id);

        return $this->success($result,900004);
    }
}
