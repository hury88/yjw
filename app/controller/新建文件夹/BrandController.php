<?php
namespace App\controller;
use App\model\Brand as Brand;
use App\model\BrandModels as BrandModels;

class BrandController extends ApiController
{
    /**
     * 根据需要的品牌id集合获取存在的品牌信息
     * @param $brand_ids
     */
    public function getList($brand_ids)
    {
        if(empty($brand_ids)) $this->error('缺少城市支持的品牌字段');
        $brandModel = new Brand();//ModelFactory('brand');
        $brandList = $brandModel->getField('id,title,img1,initials', 'isstate=1 and id in('.$brand_ids.')', 'initials asc');
        $brandListGroupByInitials = array_group($brandList,'initials');

        $this->success([
            'brandList' => $brandListGroupByInitials,
            'brandInitialsList' => array_keys($brandListGroupByInitials),
        ], '支持的品牌及简拼集合');
    }

    /**
     * 获取品牌下所有的车型
     * @param $brand_id
     */
    public function getBrandModelsList($brand_id)
    {
        if(empty($brand_id)) $this->error('无效的brand_id');
        $brandModelsModel = new BrandModels();
        $brandModelsList = $brandModelsModel->select('id,title,img1', 'isstate=1 and brand_id = '.$brand_id);

        $this->success($brandModelsList, '品牌下的所有车型');
    }

    /**
     * 获取车型的基本信息
     * @param $id
     *
     */
    public function getBrandModelbasicInfo($id)
    {
        if(empty($id)) $this->error('id不能为空');
        $brandModelsModel = new BrandModels();
        if($basicInfo = $brandModelsModel->findByBrand_id($id)) {
            $color_property = $basicInfo['color_property'];
            $model_property = $basicInfo['model_property'];
            //解析2个属性
            #$color_property为|隔开的值
            #$model_property为json格式的字符串
            $colorPropertys = strpos($color_property, '|') ? explode('|', $color_property) : [];
            $modelPropertys = $model_property ? json_decode(htmlspecialchars_decode($model_property)) : [];

            $basicInfo['color_property'] = $colorPropertys;
            $basicInfo['model_property'] = $modelPropertys;
        } else {
            $basicInfo['color_property'] = [];
            $basicInfo['model_property'] = [];
        }

        $this->success($basicInfo, '该品牌的基本信息');
    }
}