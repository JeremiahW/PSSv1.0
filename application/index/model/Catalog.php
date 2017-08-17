<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 1:20 AM
 */

namespace app\index\model;



use think\Model;

class Catalog extends Model
{
    protected $table = "pss_product_catalog";


    public function parent(){
        return $this->belongsTo("Catalog", "parent_id", "id")->field("id,subject");
    }

    public function children(){
        return $this->hasMany("Catalog","parent_id", "id")->where(["is_deleted"=>0]);
    }


}