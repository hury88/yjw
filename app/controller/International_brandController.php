<?php
/*** Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/6/18
 * Time: 12:47
 */

namespace App\controller;

use App\model\Brand as Brand;

class International_brandController extends ApiController
{
    public function getBrandTypeList($type_value)
    {
        $type_value = intval($type_value);
        $brandModel = new Brand();

        $brandList = $brandModel->select(null, 'isstate=1 and type_value='.$type_value);

        $this->json([
            'brand_list' => $brandList,
        ]);
    }

    public function getBrandInfo($brand_value)
    {
        $brand_value = intval($brand_value);
        $brandModel = new Brand();

        $data = $brandModel->find($brand_value);

        $this->json($data);
    }

}