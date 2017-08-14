<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/4/2017
 * Time: 2:20 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use think\Loader;
use think\Request;

class Supplier extends BaseController
{
    protected $model;
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = Loader::model("Supplier", "logic");
    }

    function index()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":index");
    }
    function get(){
        // pageSize, pageNumber, searchText, sortName, sortOrder.

        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $this->model->Get(-1, $offset, $pageSize);
        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }

    function save(){
        if(Request::instance()->isPost()){
            $id = Request::instance()->param("id");
            $company = Request::instance()->param("company");
            $address = Request::instance()->param("address");
            $description = Request::instance()->param("description");

            $file  = \request()->file("logo");
            $fullPath = "";
            $uploads =  'public' . "/" . 'uploads'."/".'company';
            $info = $file->move(ROOT_PATH.$uploads);
            if($info){
                 //  $ext = $info->getExtension();
                 //  $fileName = $info->getFilename();
                   $saveName = $info->getSaveName();
                   $fullPath = $uploads."/".$saveName;
            }
            else {
                $result = $file->getError();
            }

            $model = Loader::model("Supplier", "logic");
            $result = $model->Save($id, $company, $address, $description, $fullPath);
            return json($result);
        }
    }
}