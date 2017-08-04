<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/27/2017
 * Time: 1:22 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Group extends BaseController
{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    function index(){
        return $this->fetch( ":index");
    }

    function save(){
        if(Request::instance()->isPost()){
            $id = Request::instance()->param("id");
            $subject = Request::instance()->param("subject");
            $description = Request::instance()->param("description");
            $seqno = Request::instance()->param("seqno");

            $m = Loader::model("Department", "logic");

            $result = $m->Save($id, $subject, $description, $seqno);
        }
        else
        {
            $result = false;
        }

        return json($result);
    }
}