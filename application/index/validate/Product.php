<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/23/2017
 * Time: 3:56 AM
 */

namespace app\index\validate;


use think\Validate;

class Product extends Validate
{
    protected $rule = [
        'catalog_id'=>'require|number',
        'supplier_id'=>'require|number',
        'code'=>'require|max:20',
        'sku'=>'require|max:20',
        'spu'=>'require|max:20',
        'subject'=>'require|max:20',
        'unit_price'=>'require|number',
        'warning_amount'=>'require|number',
    ];

    protected $message = [
        'catalog_id.require'=>'请选择产品所属分类',
        'catalog_id.number'=>'产品所属分类为数字',
        'supplier_id.require'=>'请选择产品供应商',
        'supplier_id.number'=>'产品供应商必需为数字',
        'code.require'=>'产品编码',
        'code.max'=>'产品编码不能超过20个字符',
        'sku.require'=>'SKU是必填的',
        'sku.max'=>'SKU长度不能超过20个字符',
        'spu.require'=>'SPU是必填的',
        'spu.max'=>'SPU长度不能超过20个字符',
        'unit_price.require'=>'单价是必填的',
        'unit_price.number'=>'单价只能是数字',
        'warning_amount.require'=>'预警数量为必填字段',
        'warning_amount.number'=>'预警数量必需为数字',
    ];
}