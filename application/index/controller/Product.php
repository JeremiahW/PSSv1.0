<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 11:07 PM
 */

namespace app\index\controller;


use app\common\BaseController;
use app\index\model\SpecificationType;
use think\Loader;
use think\Request;

class Product extends BaseController
{
    //private $specificationType;
   // private $specification;

    function __construct(Request $request = null)
    {
        parent::__construct($request);

      //  $this->specificationType = Loader::model("SpecificationType");
      //  $this->specification = Loader::model("Specification", "logic");
    }

    function index()
    {
        $model = Loader::model("specificationType");
        $types = $model->select();
        $this->assign("types", $types);
        return $this->fetch(":index");
    }

    function show()
    {
        $this->assign("pageSize", $this->pageSize);
        $this->assign("serverRoot", $this->serverRoot);
        return $this->fetch(":show");
    }

    function save()
    {
        if(Request::instance()->isPost())
        {
            $form = Request::instance()->post("form/a");
            $rows = Request::instance()->post("specifications/a");

            $product = [
                "catalog_id" => $form["catId"],
                "supplier_id" => $form["supplierId"],
                "code" => $form["code"],
                "sku" => $form["sku"],
                "spu" => $form["spu"],
                "subject" => $form["subject"],
                "unit_price" => $form["unit_price"],
                "warning_amount" => $form["warning_amount"],
                "id"=>$form["id"],
            ];

            $model = Loader::model("Product", "logic");
            if(empty($form["id"]))
            {
                $result = $model->Save($product, $rows);
            }
            else
            {
                $result = $model->Save($product, $rows, $form["id"]);
            }
            return json($result);
        }
        else
        {
            return false;
        }
    }

    function get()
    {
        $model = Loader::model("Product", "logic");

        $condition['id'] = array('<>', "null");

        $term = Request::instance()->param("q");
        $page = Request::instance()->param("page");

        $offset = Request::instance()->param("offset");
        $pageSize = Request::instance()->param("limit");
        $resultSet = $model->Get($page, $offset, $pageSize, $condition);

        return json(["total"=>$resultSet["count"], "rows"=>$resultSet["rows"]]);
    }
}