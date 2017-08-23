<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 4:32 AM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Client extends BaseController
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    function index()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":index");
    }

    function get()
    {

        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");

        $condition['id'] = array('<>', "null");
        if(!empty($term)){
            $condition['name'] = array('like', "%$term%");
        }

        $model = Loader::model("Client", "logic");

        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $model->Get($page, $offset, $pageSize, $condition);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function save()
    {
        if(Request::instance()->isPost())
        {
            $name = Request::instance()->param("name");
            $email = Request::instance()->param("email");
            $phone = Request::instance()->param("phone");
            $description = Request::instance()->param("description");
            $shenfenzheng = Request::instance()->param("shenfenzheng");
            $id = Request::instance()->param("id");

            $client = [
                "name"=>$name,
                "phone"=>$phone,
                "address"=>$phone,
                "email"=>$email,
                "description"=>$description,
                "shenfenzheng"=>$shenfenzheng
            ];

            $m = Loader::model("Client","logic");
            $result = $m->Save($client, $id);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }
}