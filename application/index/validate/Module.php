<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/31/2017
 * Time: 2:28 PM
 */

namespace app\index\validate;


use think\Validate;

class Module extends Validate
{
    protected $rule = [
        'subject'=>'require|max:20',
        'module'=>'require|max:200',
        'controller'=>'require|max:200',
        'action'=>'require|max:200',
        'icon'=>'require|max:100',
        'parent_id'=>'require|max:9999',
    ];

    protected $message = [
        'subject.require'=>'菜单名称为必填字段',
        'subject.max'=>'菜单名称的长度为20个字符',
        'module.require'=>'模块为必填字段',
        'module.max'=>'模块的长度为200个字符',
        'controller.require'=>'控制器为必填字段',
        'controller.max'=>'控制器的长度为200个字符',
        'action.require'=>'行为是必填字段',
        'action.max'=>'行为的长度为200个字符',
        'icon.require'=>'图标为必填字段',
        'icon.max'=>'图标的长度为200个字符',
        'parent_id.require'=>'上一级为必填字段',
        'parent_id.max'=>'上一级的长度为100个字符',
    ];
}