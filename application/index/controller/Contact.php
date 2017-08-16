<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/15/2017
 * Time: 2:56 AM
 */

namespace app\index\controller;


use app\common\BaseController;
use app\index\model\SupplierContact;
use think\Loader;
use think\Request;

class Contact extends BaseController
{
    protected $model;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = Loader::model("SupplierContact", "logic");
    }

    function get()
    {
        $sid = Request::instance()->param("sid");
        if(!empty($sid))
        {
            $offset = Request::instance()->param("offset");
            $pageSize = Request::instance()->param("limit");
            $resultSet = $this->model->Get(-1, $offset, $pageSize, $sid);
            return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
        }
    }

    function save()
    {
        if(Request::instance()->isPost())
        {
            $id = Request::instance()->param("id");
            $companyId = Request::instance()->param("companyId");
            $name  = Request::instance()->param("name");
            $phone  = Request::instance()->param("phone");
            $email  = Request::instance()->param("email");
            $position = Request::instance()->param("position");
            $description =  Request::instance()->param("description");

            $m = Loader::model("SupplierContact", "logic");
            $result = $m->Save($id, $name, $email, $phone, $position, $description, $companyId);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }

}