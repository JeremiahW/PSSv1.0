<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 4:32 AM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Request;

class Client extends BaseController
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