<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 11:18 PM
 */

namespace app\index\model;


use think\Model;

class Specification extends Model
{
    public function type()
    {
        return $this->belongsTo("SpecificationType", "type_id", "id")->field("id, subject");
    }
}