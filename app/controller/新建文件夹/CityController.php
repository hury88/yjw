<?php
namespace App\controller;
use App\model\City as City;

class CityController extends ApiController
{
    private $cityModel= null;
    public function __construct()
    {
        $this->cityModel = new City();
    }

    /**
     * 根据小程序的给的定位返回城市信息
     */
    public function location($appletsCityLocation)
    {
        $rs = $this->cityModel->findByTitle($appletsCityLocation);
        if(! $rs) $rs = $this->cityModel->selectOne('id,title,brand_ids,is_grab', 'isstate=1');

        $this->success($rs);

    }
    public function group()
    {
        $data = $this->cityModel->getGroupCitys();

        $this->success($data);
    }
    public function grab()
    {
        $data = $this->cityModel->getGrabCitys();

        $this->success($data);
    }
}