<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 10:54 PM
 */

namespace app\index\controller;


use app\common\BaseController;
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
}