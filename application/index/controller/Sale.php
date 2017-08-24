<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 10:54 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Sale extends BaseController
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

    function sale()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":sale");
    }

    function total()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":total");
    }

    function save()
    {
        if(Request::instance()->isPost())
        {
            $cid = Request::instance()->param("cid");
            $products =Request::instance()->param("products/a");
            $uid = Request::instance()->param("uid");
            $description = Request::instance()->param("description");

            $model = Loader::model("Sale", "logic");
            $result = $model->Save($products,$description, $cid, $uid);
            return json($result);
        }
        else
        {
            return json(false);
        }
    }

    function get()
    {
        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");

        $condition['id'] = array('<>', "null");
        if(!empty($term)){
            $condition['company'] = array('like', "%$term%");
        }

        $model = Loader::model("Sale", "logic");
        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $model->Get($page, $offset, $pageSize, $condition);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);

    }
}