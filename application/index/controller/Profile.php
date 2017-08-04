<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/4/2017
 * Time: 2:19 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Request;

class Profile extends BaseController
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

}