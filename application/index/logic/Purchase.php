<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 9/5/2017
 * Time: 10:22 AM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Loader;

class Purchase extends BaseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function Get($page, $offset = -1, $pageSize=-1, $condition=[]){
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }

        $model = Loader::model("Purchase");
        $count = $model->with("items,type,items.product,sale,sale.user")->where($condition)->count();
        $rows = $model->with("items,type,items.product,sale,sale.user")->where($condition)->limit($offset,$pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

}