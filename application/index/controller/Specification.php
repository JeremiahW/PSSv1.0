<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 10:25 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Specification extends BaseController
{
    protected $model;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = Loader::model("Specification", "logic");
    }

    function index()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":specification");
    }

    function type()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":type");
    }

    function get()
    {
        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $this->model->Get(-1, $offset, $pageSize);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function save()
    {
        if(Request::instance()->isPost()){
            $id = Request::instance()->param("id");
            $subject = Request::instance()->param("subject");

            $m = Loader::model("Specification", "logic");

            $result = $m->Save($id, $subject);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }
}