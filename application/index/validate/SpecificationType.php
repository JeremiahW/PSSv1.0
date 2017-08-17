<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/17/2017
 * Time: 11:44 PM
 */

namespace app\index\validate;


use think\Validate;

class SpecificationType extends Validate
{
    protected $rule = [
        'subject'=>'require|max:20',
    ];

    protected $message = [
        'subject.require'=>'菜单名称为必填字段',
        'subject.max'=>'菜单名称的长度为20个字符',
    ];
}