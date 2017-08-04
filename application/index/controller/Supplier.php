<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/4/2017
 * Time: 2:20 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Request;

class Supplier extends BaseController
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
}