<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 10:54 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use app\common\PssUtils;
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
        $startDate = Request::instance()->param("startDate");
        $endDate = Request::instance()->param("endDate");
        $orderNumber = Request::instance()->param("orderNumber");
        $sid = Request::instance()->param("sid");
        $cid = Request::instance()->param("cid");


        $condition['id'] = array('<>', "null");
        if(!empty($term)){
            $condition['company'] = array('like', "%$term%");
        }

        if(!empty($orderNumber)){
            $condition['order_number'] = array('=', "$orderNumber");
        }

        if(!empty($sid) && $sid !== -1){
            //TODO 根据权限判断用户是否有访问全部销售订单的权限.
            $condition['user_id'] = array('=', "$orderNumber");
        }

        if(!empty($cid) && $cid !== "-1"){
            $condition['client_id'] = array('=', "$orderNumber");
        }

        if(!empty($startDate)){
            $condition['create_time'] = array('>=', strtotime($startDate));
        }

        if(!empty($endDate)){
            $condition['create_time'] = array('<=', strtotime($endDate));
        }


        $model = Loader::model("Sale", "logic");
        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $order = Request::instance()->param("order");
        $resultSet = $model->Get($page, $offset, $pageSize, $condition);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);

    }
}