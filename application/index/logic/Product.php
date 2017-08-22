<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/22/2017
 * Time: 3:40 AM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Exception;
use think\Loader;

class Product extends BaseModel
{
    private $product;
    private $productSpec;

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        $this->product = Loader::model("Product");
        $this->productSpec = Loader::model("ProductSpecification");
    }

    public function Save($product, $specifications)
    {
        $validate = Loader::validate("Product");
        $result = $validate->batch()->check($product);
        if($result !== true)
            return $validate->getError();

        Db::startTrans();

        try
        {
           // $id =$this->product->insertGetId($product);
            $this->product->save($product);
            $id = $this->product->getLastInsID();

            $data = array();
            //$rows = json_decode($specifications);
            foreach ($specifications as $row)
            {
                array_push($data, ["specification_id"=>$row["id"], "product_id"=>$id, "specification"=>$row["specification"]]);
            }
            $this->productSpec->saveAll($data);
            Db::commit();
        }
        catch (Exception $exp)
        {
            $result = $exp->getMessage();
            Db::rollback();
        }

        return $result;


        /*
        if(!$result)
            return $validate->getError();
        else
            return $result;*/
    }

    public function Update($product, $specifications, $id)
    {
        $validate = Loader::validate("Product");
        $result = $validate->batch()->check($product);
        if($result !== true)
            return $validate->getError();

        Db::startTrans();

        try
        {
            // $id =$this->product->insertGetId($product);
            $this->product->save($product, ["id"=>$id]);

            //更新数据,规格表全部删除然后重新添加
            $this->productSpec->where("product_id", $id)->delete();

            $data = array();
            //$rows = json_decode($specifications);
            foreach ($specifications as $row)
            {
                array_push($data, ["specification_id"=>$row["id"], "product_id"=>$id]);
            }
            $this->productSpec->saveAll($data);
            Db::commit();
        }
        catch (Exception $exp)
        {
            $result = $exp->getMessage();
            Db::rollback();
        }

        return $result;
    }

    public function Get($page, $offset = -1, $pageSize=-1, $condition=[])
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }


        $model = Loader::model("Product");

        $count = $model->with("catalog,supplier,specifications,specifications.type")->where($condition)->count();
        $rows = $model->with("catalog,supplier,specifications,specifications.type")->where($condition)->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

    public function GetRow($id)
    {
        $model = Loader::model("Product");
       // $model = new \app\index\model\Product();
        $condition['id'] = array('=', $id);

        $rows = $model->with("catalog,supplier,specifications,specifications.type")->where($condition)->select();
        if(sizeof($rows)>0)
        {
            return $rows[0];
        }
        else
        {
            return null;
        }
    }
}