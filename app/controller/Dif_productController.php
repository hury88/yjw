<?php
/*** Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/6/18
 * Time: 12:47
 */

namespace App\controller;

use App\model\Product as Product;
use Core\Page as Page;

class Dif_productController extends ApiController
{
    public function getFrameList($index, $prod_brand, $prod_series, $order_by, $prod_type)
    {
        //$productModel = new Product();
        $prod_brand = (int) $prod_brand;
        $prod_series = (int) $prod_series;

        $pageConfig = array(

            'page' => $index,

            'where' => 'prod_brand='.$prod_brand.' and prod_series='.$prod_series,//条件
            'order' => $order_by ? $order_by.' desc' : '',//排序
            'psize' => 20,//条数
            'table' => Product::TABLE,//表
            'field' => Product::TABLE_FIELD,//表字段
        );

        $page = new Page($pageConfig);

        $this->json([
           'data'=>$page->data
        ]);
    }
}