<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/1/2017
 * Time: 11:36 AM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Department extends BaseController
{
    protected $model;
    function __construct(Request $request = null)
    {
        parent::__construct($request);

        $this->model = Loader::model("Department", "logic");
    }

    function index()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch( ":index");
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
            $description = Request::instance()->param("description");
            $seqno = Request::instance()->param("seqno");

            $m = Loader::model("Department", "logic");

            $result = $m->Save($id, $subject, $description, $seqno);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }

    function inactive(){
        $ids = Request::instance()->param("ids");
        $result = $this->model->UpdateStatus($ids, 1);
        return $result;
    }

    function active(){
        $ids = Request::instance()->param("ids");
        $result = $this->model->UpdateStatus($ids, 0);
        return $result;
    }
}