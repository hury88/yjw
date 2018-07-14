<?php
namespace App\model;
/*
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`brand_id`  int(11) NOT NULL ,
`title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`prod_color`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '颜色属性' ,
`mirr_width`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '车型属性' ,
`nose_width`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`shape`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`style`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`version`  text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`disorder`  int(11) NOT NULL DEFAULT 0 ,
`isstate`  tinyint(4) NOT NULL DEFAULT 1 ,
`isgood`  tinyint(4) NOT NULL DEFAULT 0 ,
`sendtime`  int(11) NOT NULL ,
 */
class BrandModels extends Model
{
    const TABLE = 'brand_models';
    const TABLE_ORDER = 'isgood desc, disorder desc, sendtime desc, id asc';

}