<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/15/2017
 * Time: 10:37 PM
 */

namespace app\index\logic;


use app\common\BaseModel;
use think\Db;
use think\Loader;

class SupplierContact extends BaseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function Get($page, $offset=-1, $pageSize = -1, $sid)
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }

        $condition = [
            "company_id"=>["=", $sid]
        ];

        $count = Db::table($this->prefix."supplier_contact")->where($condition)->count();
        $rows = Db::table($this->prefix."supplier_contact")->where($condition)->limit($offset, $pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }

    public function Save($id, $name, $email, $phone, $position, $description, $companyId)
    {
        $data = [
            "company_id"=>$companyId,
            "name"=>$name,
            "phone"=>$phone,
            "email"=>$email,
            "position"=>$position,
            "description"=>$description,
        ];

        $validate = Loader::validate("SupplierContact");
        $model = Loader::model("SupplierContact");

        if(empty($id))
        {
            $result = $validate->batch()->check($data);
            if($result===true){
                $model->allowField(true)->save($data);
            }
        }
        else
        {
            $result = $validate->batch()->check($data);
            if($result===true){
                $model->allowField(true)->save($data, ["id"=>$id]);
            }
        }

        if(!$result)
            return $validate->getError();
        else
            return $result;
    }
}