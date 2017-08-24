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
        return $this->fetch(":index");
    }

    function sale()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":sale");
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
}