<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/19/2017
 * Time: 10:09 AM
 */

namespace app\index\controller;


use app\common\BaseController;
// use app\index\validate\User;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use think\Validate;

class User extends BaseController
{
    protected $user;

    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->user = Loader::model("User", "logic");
    }

    function users(){
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":user");
    }

    function get(){
        // pageSize, pageNumber, searchText, sortName, sortOrder.

        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $this->user->Get(-1, $offset, $pageSize);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["users"]]);
    }

    function save()
    {
        if(Request::instance()->isPost())
        {
            $id = Request::instance()->param("id");
            $username = Request::instance()->param("username");
            $password = Request::instance()->param("password");
            $repassword = Request::instance()->param("repassword");
            $chinese = Request::instance()->param("chinese");
            $phone = Request::instance()->param("phone");
            $email = Request::instance()->param("email");

            $user = Loader::model("User", "logic");

            $result = $user->Save($id, $username, $password, $repassword, $chinese, $phone, $email);
        }
        else
        {
            $result = false;
        }

        return json($result);


    }

    function inactive(){
        $users = Request::instance()->param("users");
        $result = $this->user->UpdateStatus($users, 1);

        return $result;
    }

    function active()
    {
        $users = Request::instance()->param("users");
        $result = $this->user->UpdateStatus($users, 0);

        return $result;
    }
}