<?php
namespace App\controller;
use App\Model\City as City;

class GroupController extends ApiController{

    public function getCity()
    {
    	$city = new City();

    	$city->select('id,title', );
    }
}