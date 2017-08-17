<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 9:40 PM
 */

namespace app\index\validate;


use think\Validate;

class Catalog extends Validate
{
    protected $rule = [
        'subject'=>'require|max:20',
        'parent_id'=>'require|max:9999',
    ];

    protected $message = [
        'subject.require'=>'菜单名称为必填字段',
        'subject.max'=>'菜单名称的长度为20个字符',
        'parent_id.require'=>'上一级为必填字段',
        'parent_id.max'=>'上一级的长度为100个字符',
    ];
}