<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/22/2017
 * Time: 3:45 AM
 */

namespace app\index\model;


use think\Model;

class Product extends Model
{
    public function catalog()
    {
        return $this->belongsTo("Catalog","catalog_id","id")->field("id, subject");
    }

    public function supplier()
    {
        return $this->belongsTo("Supplier","supplier_id","id")->field("id, company");

    }

    public function specifications()
    {
        // return $this->hasMany("ProductSpecification","product_id","id")->field("product_id,specification_id,specification");

        return $this->belongsToMany("Specification", "ProductSpecification", "specification_id", "product_id");
    }
}