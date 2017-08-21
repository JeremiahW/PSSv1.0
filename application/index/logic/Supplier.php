<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/14/2017
 * Time: 8:36 PM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Loader;

class Supplier extends BaseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function Get($page, $offset=-1, $pageSize = -1, $condition=[])
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }


        $count = Db::table($this->prefix."supplier")->where($condition)->count();
        $rows = Db::table($this->prefix."supplier")->where($condition)->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

    public function Save($id, $company, $address, $description, $logo)
    {

        $data = [
            "company"=>$company,
            "address"=>$address,
            "description"=>$description,
            "logo"=>$logo,
        ];

        $validate = Loader::validate("Supplier");
        $model = Loader::model("Supplier");
        if(empty($id))
        {
            $result = $validate->batch()->scene("add")->check($data);
            if($result === true){
                $model->allowField(true)->save($data);
            }
        }
        else if(empty($logo)){
            //把Logo的键值从数组中删除，并重建索引
            unset($data["logo"]);
            $data = array_values($data);

            $result = $validate->batch()->scene("editNoImage")->check($data);
            if($result){
                $model->allowField(true)->save($data, ["id"=>$id]);
            }
        }
        else{
            $result = $validate->batch()->scene("edit")->check($data);
            if($result){
                $model->allowField(true)->save($data, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }
}