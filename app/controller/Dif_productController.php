<?php
/*** Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/6/18
 * Time: 12:47
 */

namespace App\controller;

use App\model\Product as Product;
use App\model\Person as Person;
use Core\Page as Page;

class Dif_productController extends ApiController
{
    public function getFrameList($index, $prod_brand, $prod_series, $order_by, $prod_type, $version, $prod_color, $mirr_width, $nose_width, $shape, $style)
    {
        $jjOrder = config('custome.jj_order');


        $map = array();
        //$productModel = new Product();
        $prod_brand = (int) $prod_brand; $prod_brand and $map['prod_brand'] = $prod_brand;
        $prod_series = (int) $prod_series; $prod_series and $map['prod_series'] = $prod_series;

        $version and $map['version'] = $version;
        $prod_color and $map['prod_color'] = $prod_color;
        $mirr_width and $map['mirr_width'] = $mirr_width;
        $nose_width and $map['nose_width'] = $nose_width;

        (int)$shape and $map['shape'] =  (int)$shape;
        (int)$style and $map['style'] =  (int)$style;


        $pageConfig = array(

            'page' => $index,

            'where' => $map,//条件
            'order' => $order_by ? $jjOrder[$order_by] : '',//排序
            'psize' => 20,//条数
            'table' => Product::TABLE,//表
            'field' => Product::TABLE_FIELD.','.(Person::get()->isLogin()?'market_price':'"价格登录可见" as market_price'),//表字段
        );

        $page = new Page($pageConfig);
        // _sql();

        $this->json([
           'data'=>$page->data
        ]);
    }
}