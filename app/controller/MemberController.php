<?php
/**
 * Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/7/15
 * Time: 19:15
 */

namespace App\controller;

use App\model\Person as Person;

class MemberController extends Controller
{
    public function getUserInfo()
    {
        $person = Person::get();
        if ($person->isLogin()) {
            $result = array(
                'XYanJ_C_Nam' => $person->name,
                'XYanJ_C_id' => $person->id,
                'custType' => '',
                'custGrade' => ''
            );
            die(json_encode($result));
        }
        die('{"XYanJ_C_Nam":"","XYanJ_C_id":"","custType":"","custGrade":"","custParent":""}');
    }

}