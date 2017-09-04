<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 9/4/2017
 * Time: 5:23 PM
 */

namespace app\index\controller;


use app\common\BaseController;
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

}