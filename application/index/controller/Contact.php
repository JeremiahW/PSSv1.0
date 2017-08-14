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
use think\Request;

class Contact extends BaseController
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    function get(){
        $sid = Request::instance()->param("sid");
        if(!empty($sid))
        {
            $model = new SupplierContact();
            return json($model->select());
        }
    }

}