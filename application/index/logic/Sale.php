<?php
/**
 * Created by PhpStorm.
 * User: Jixiao
 * Date: 8/24/2017
 * Time: 10:36 PM
 */

namespace app\index\logic;


use app\common\BaseModel;
use app\index\model\Purchase;
use app\index\model\PurchaseItem;
use app\index\model\SaleProduct;
use think\Db;
use think\Exception;
use think\Loader;
use think\Model;

class Sale extends BaseModel
{
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    //默认销售人员是管理员Admin
    public function Save($products, $description,$cid, $uid=1)
    {
        //$product = Loader::model("Product");
        //$sale = Loader::model("Sale");

        $product = new \app\index\model\Product();
        $sale = new \app\index\model\Sale();
        $saleProduct = new SaleProduct();
        $purchase = new Purchase();

        Db::startTrans();

        //保存订单
        $saleId = -1;
        $saleOrder = [
            "client_id"=>$cid,
            "user_id"=>$uid,
            "description"=>$description,
        ];

        try {
            $sale->save($saleOrder);
            $saleId = $sale->getLastInsID();
            $saleTypeId = -1;
            $totalAmt = 0;
            $totalActAmt = 0;
            $purchaseItems = array();

            foreach ($products as $p) {
                //根据产品ID 获取产品库存。
                $pid = $p["id"];

                $amount = $p["number"]; //当前用户购买数量
                $unitPrice = $p["unit_price"]; //购买时的单价,供后期参考
                $actCost = $p["actAmt"]; //实际消费
                $totalCost = $p["totalAmt"]; //总消费

                $totalActAmt += $actCost;  //实际所有产品总价
                $totalAmt += $totalCost;  //预计所有产品总价

                //库存数量 TODO 考虑一下是不是应该从仓库那边操作。
                $storedAmt = $product->where("id", $pid)->find()["amount"];

                //如果库存大于=销售数量，则生成销售单。
                if ($storedAmt >= $amount) {
                    $saleTypeId = 1;

                    //库存剩余量
                    $leftAmt = $storedAmt - $amount;

                    //购买的产品记录进销售订单详情库。
                    $data = [
                        "product_id" => $pid, //产品的ID
                        "total" => $amount,   //产品采购数量
                        "amount" => $totalCost,
                        "actual_amount" => $actCost,
                        "sale_id" => $saleId,
                        "unit_price" => $unitPrice,
                        "total_pending" => 0,   //没有待采购的产品
                    ];

                    //生成销售订单的详情数据
                    $saleProduct->save($data);

                    //TODO 已经销售的数量,记录至库存管理表中, 出库操作. 记录一条出库日志.

                    //库存数量需要更新进仓库管理那部份。更新Product的数量,便于查询.
                    $product->save(["amount" => $leftAmt], ["id" => $pid]);
                } else {
                    $saleTypeId = 2; //待采购
                    //如果库存小于=销售数量，则生成销售单。同时多余部份生成采购单。
                    $totalPending = $amount - $storedAmt;

                    //TODO 已经销售的数量,记录至库存管理表中, 出库操作.

                    //购买的产品记录进销售订单详情库。
                    $data = [
                        "product_id" => $pid, //产品的ID
                        "total" => $storedAmt,   //产品采购数量,因为库存小于购买,所以全部库存都加到.
                        "amount" => $totalCost,
                        "actual_amount" => $actCost,
                        "sale_id" => $saleId,
                        "unit_price" => $unitPrice,
                        "total_pending" => $totalPending, //待采购的产品数量
                    ];

                    $saleProduct->save($data);

                    //库存数量需要更新进仓库管理那部份。
                    $product->save(["amount" => $storedAmt - $amount], ["id" => $pid]);


                    //TODO 先生成一条采购订单的记录；然后循环内的数据为采购的明细信息。
                    //自动生成采购订单
                    array_push($purchaseItems, [
                        "sale_id" => $saleId,
                        "product_id" => $pid,
                        "amount" => $totalPending,
                        "state" => 1, //提交审核,
                        "purchase_id"=>-1,
                    ]);
                }


            }

            //TODO 如果有采购订单，则生成采购订单信息。
            if(sizeof($purchaseItems) > 0){
                $purchase->save([
                   "sale_id"=>$saleId,
                   "code"=>"CODE001",
                    "state"=>"1"
                ]);
                $purchase_id = $purchase->getLastInsID();

                $item = new PurchaseItem();
                //TODO 把purchaseItems里面的purchase_id替换一下。
                $item->saveAll($purchaseItems);
            }
            // $purchase->save();


            //更新订单信息
            $sale->allowField(true)->save(["type_id" => $saleTypeId,
                "total_amount" => $totalAmt,
                "total_actual_amount" => $totalActAmt,
                "order_number" => time()],
                ["id" => $saleId]);

            Db::commit();
            return true;
        }catch (Exception $exp){
            Db::rollback();
            return $exp->getMessage();
        }


    }


    public function Get($page, $offset = -1, $pageSize=-1, $condition=[])
    {
        if($pageSize==-1){
            $pageSize = config('paginate.list_rows');
        }

        if($offset==-1){
            $page = 0;
            $offset = $page *  $pageSize;
        }
        $model = Loader::model("Sale");
        $count = $model->with("client,user,type,products,products.specifications")->where($condition)->count();
        $rows = $model->with("client,user,type,products,products.specifications")->where($condition)->limit($offset,$pageSize)->select();
        return ["rows"=>$rows, "count"=>$count];
    }
}