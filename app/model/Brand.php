<?php
namespace App\model;
/*
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`brand_image`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`disc_img_path`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`brand_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称' ,
`international`  tinyint(4) NOT NULL COMMENT '所属分类1,' ,
`recommend`  tinyint(4) NOT NULL DEFAULT 0 ,
`type_value`  tinyint(4) NOT NULL DEFAULT '-1' ,
`views`  int(11) NOT NULL DEFAULT 1 ,
`disorder`  int(11) NOT NULL DEFAULT 0 ,
`isstate`  tinyint(4) NOT NULL DEFAULT 1 ,
`sendtime`  int(11) NOT NULL ,
 */
class Brand extends Model
{
    const TABLE = 'brand';
    const TABLE_ORDER = 'recommend desc, disorder desc, sendtime desc, id asc';
    const TABLE_FIELD = 'id,id as brand_value,international,type_value,recommend,brand_name,brand_image,brand_name,brand_name,disc_img_path';


    //获取首字母
    public function getInitialsSet($field, $getField=false)
    {
        if ($getField) {

            return $this->getDbInstance()->where('isstate=1')->group('initials')->order('initials asc')->getField($field);
        }
        return $this->getDbInstance()->field($field)->where('isstate=1')->group('initials')->order('initials asc')->select();

    }

}