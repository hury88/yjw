<?php
/*** Created by PhpStorm.
 * User: 胡锐
 * Date: 2018/6/18
 * Time: 12:47
 */

namespace App\controller;


class Multi_supplierController extends ApiController
{
    public function getMultiSupplierInfo()
    {
        $this->json([
           'list'=>[]
        ]);
    }
}