<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/16/2017
 * Time: 10:03 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Catalog extends BaseController
{
    protected $model;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = Loader::model("Catalog", "logic");
    }

    function index()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":index");
    }

    function get()
    {
        $model = Loader::model("Catalog", "logic");
        $resultSet = $model->Get();
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function get2()
    {
        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");
        $pageSize = config('paginate.list_rows');

        $condition['subject'] = array('like', "%$term%");
        $resultSet = $this->model->Get2($condition, $page, $pageSize);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);

    }

    function save()
    {
        if(Request::instance()->isPost())
        {
            $id = Request::instance()->param("id");
            $parent_id = Request::instance()->param("pid");
            $subject = Request::instance()->param("subject");

            $description = Request::instance()->param("description");
            $seqno = Request::instance()->param("seqno");

            $m = Loader::model("Catalog","logic");

            $result = $m->Save($id, $subject, $description, $parent_id, $seqno );
        }
        else
        {
            $result = false;
        }
        return json($result);
    }

}