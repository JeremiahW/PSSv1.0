<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 9/4/2017
 * Time: 5:23 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Purchase extends BaseController
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    function index()
    {
        return $this->fetch(":index");
    }

    function get()
    {

        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");

        $model = Loader::model("Purchase", "logic");


        //过滤掉已经删除的
        $condition['id'] = array('<>', "-1");
        if(!empty($term)){
            $condition['code'] = array('like', "%$term%");
        }

        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $model->Get($page, $offset, $pageSize, $condition);

        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }
}