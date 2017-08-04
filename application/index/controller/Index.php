<?php
namespace app\index\controller;

use app\common\BaseController;
use think\Controller;
use think\Request;

class Index extends BaseController
{
    public function index()
    {
         return $this->fetch( ":index");
    }

    public function logoff(){

    }

    public function login(){
        if(Request::instance()->isPost()){
            $user = Request::instance()->param("u");
            $password = Request::instance()->param("u");
            $referTo = Request::instance()->get("referTo");
            if(!empty($referTo)){
                $this->redirect($referTo);
            }
            else{
                $this->redirect("index/index/index");
            }
        }
       return $this->fetch(":login");
    }
}
