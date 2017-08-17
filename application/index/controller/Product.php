<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 11:07 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Request;

class Product extends BaseController
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    function index()
    {

    }

}