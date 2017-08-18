<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/19/2017
 * Time: 3:02 AM
 */

namespace app\index\validate;


use think\Validate;

class Specification extends Validate
{
    protected $rule = [
        'subject'=>'require|max:20',
        'code'=>'require|max:20',
        'type_id'=>'require|max:20',
    ];

    protected $message = [
        'subject.require'=>'编码为必填字段',
        'subject.max'=>'编码的长度为20个字符',
        'code.require'=>'编码为必填字段',
        'code.max'=>'编码的长度为20个字符',
        'type_id.require'=>'分类名称为必填字段',
        'type_id.max'=>'分类名称的长度为20个字符',
    ];
}