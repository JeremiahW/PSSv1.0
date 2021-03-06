<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 10:25 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Db;
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

    function gettype()
    {
        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");

        $condition['id'] = array('<>', "null");
        if(!empty($term)){
            $condition['subject'] = array('like', "%$term%");
        }


        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $this->model->GetType($page, $offset, $pageSize,$condition);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function savetype()
    {
        if(Request::instance()->isPost()){
            $id = Request::instance()->param("id");
            $subject = Request::instance()->param("subject");

            $m = Loader::model("Specification", "logic");

            $result = $m->SaveType($id, $subject);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }

    function get()
    {
        $condition['id'] = array('<>', "null");

        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");

        $typeId = Request::instance()->post("typeId");

        //$typeId = Request::instance()->param("typeId");
        if(!empty($typeId)){
            $condition['type_id'] = array('=', "$typeId");
        }

        $resultSet = $this->model->Get(-1, $offset, $pageSize, $condition);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function save()
    {
        if(Request::instance()->isPost()){
            $id = Request::instance()->param("id");
            $subject = Request::instance()->param("subject");
            $description = Request::instance()->param("description");
            $code = Request::instance()->param("code");
            $typeId = Request::instance()->param("tid");

            $m = Loader::model("Specification", "logic");

            $result = $m->Save($id, $code, $subject,$description, $typeId);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }
}