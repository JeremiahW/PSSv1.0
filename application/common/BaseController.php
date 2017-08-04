<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 7/18/2017
 * Time: 1:59 PM
 */

namespace app\common;


use think\Config;
use think\Controller;
use think\Loader;
use think\Request;

class BaseController extends Controller
{
    private $theme = "";
    protected $theme_patch = "";

    private $module = "index";
    private $controller = "index";
    private $action = "login";
    protected $prefix = "";
    protected $pageSize = 0;
    protected $serverRoot = "http://localhost:8080/PSS/PSSv1.0/public/index.php/";
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->theme = "default";
        $this->view=$this->view->config('view_path',APP_PATH.request()->module().'/view/'.$this->theme.'/'.Request::instance()->controller().'/');

        $this->theme_patch=Config::get('view_replace_str.__ROOT__').'/application/index/view/'.$this->theme.'/';
        $this->assign('theme_patch',$this->theme_patch);

        /*
        // 引用函数库文件
        $extra_file_list = Config::get('extra_file_list');
        $function_file_list = [
            APP_PATH . '/common/common.php',
        ];

        $function_files = array_merge($extra_file_list, $function_file_list);
        Config::set("extra_file_list", $function_files);
*/

        $this->prefix = config("database.prefix");
        $this->pageSize = config("paginate.list_rows");

        $module = Request::instance()->module();
        $action = Request::instance()->action();
        $controller = Request::instance()->controller();

        //TODO 用户权限分配功能设置完成后,这里需要根据用户的权限来进行加载菜单.
        $db = Loader::model("Module", "logic");
        $menus = $db->GetForMenu();

        $this->assign("menus", $menus);


        //只有在index/index/login的时候不进行权限验证
        if( !strcasecmp($this->module, $module)
            && !strcasecmp($this->controller, $controller)
            && !strcasecmp($this->action, $action )){

            $this->assign("action", $action);
            $this->assign("module", $module);
            $this->assign("controller", $controller);


        }
        else {
            //TODO 要登录验证。
            //验证如果失败，则要跳转到登录窗口。
            //$this->redirect("index/index/login", ["referTo" => "$module/$controller/$action"]);

        }

    }

}