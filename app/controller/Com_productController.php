<?php
/*** Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/6/18
 * Time: 12:47
 */

namespace App\controller;

use App\model\Brand as Brand;
use App\model\BrandModels as BrandModels;

class Com_productController extends ApiController
{
    public function getAllProdBrand($prod_type)
    {
        $prod_type = intval($prod_type);
        $brandModel = new Brand();

        $brandList = $brandModel->select('brand_name as value,id as theindex', 'isstate=1 and type_value='.$prod_type);

        $this->json([
            'data' => $brandList,
        ]);
    }
    public function getFrameInfo($prod_brand, $type, $prod_type)
    {
        $typeMapping = ['title','shape', 'style'];
        $prod_brand = intval($prod_brand);
        $type = intval($type);$type = isset($typeMapping[$type]) ? $typeMapping[$type] : '';if(empty($type))$this->json([]);
        $brandModelsModel = new BrandModels();

        if($type == 'title') {

            $brandModelsList = $brandModelsModel->select($type.' as value,id as theindex', 'isstate=1 and brand_id = '.$prod_brand);
            $this->json([
                'data' => $brandModelsList ,
            ]);
        } else {

            $brandModelsFind= $brandModelsModel->selectOne($type, 'isstate=1 and brand_id = '.$prod_brand);

            $brandModelsFindTypeDataString= '';

            if($brandModelsFind && strpos($brandModelsFind[$type], ',')){

                $brandModelsFindTypeDataString = explode(',', $brandModelsFind[$type]);
                $configInfo = config('custome.'.$type);
                $data = [];
                foreach ($brandModelsFindTypeDataString as $index) {
                    $data[] = array('value'=>$configInfo[$index], 'theindex'=>$index);
                }
            }

            $this->json([
                'data' => $data
            ]);
        }

    }
    public function getComProdInfo($prod_brand, $type, $prod_type)
    {
        $typeMapping = ['version', 'prod_color', 'mirr_width', 'nose_width'];
        $prod_brand = intval($prod_brand);
        $type = intval($type);$type = isset($typeMapping[$type]) ? $typeMapping[$type] : '';if(empty($type))$this->json([]);
        $prod_type = intval($prod_type);

        $brandModelsModel = new BrandModels();
        $brandModelsFind= $brandModelsModel->selectOne($type.',id as theindex', 'isstate=1 and brand_id = '.$prod_brand);

        $brandModelsFindTypeDataString= '';

        if($brandModelsFind && strpos($brandModelsFind[$type], ',')){

            $brandModelsFindTypeDataString = explode(',', $brandModelsFind[$type]);
        }

        $this->json([
            'data' => $brandModelsFindTypeDataString,
        ]);
    }


}