<?php
namespace App\model;
/*
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`big_img_path`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`cust_id`  int(11) NOT NULL ,
`img_path`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`lens_refra_index`  int(11) NOT NULL ,
`lens_type`  tinyint(4) NOT NULL COMMENT 'lens_type' ,
`market_price`  decimal(10,2) NOT NULL ,
`mirr_width`  tinyint(4) NOT NULL DEFAULT 0 ,
`nose_width`  tinyint(4) NOT NULL ,
`pay_type`  tinyint(4) NOT NULL ,
`prod_brand`  int(11) NOT NULL ,
`prod_color`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`prod_material`  int(11) NOT NULL ,
`prod_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`prod_series`  int(11) NOT NULL ,
`prod_shape`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`prod_type`  tinyint(4) NOT NULL ,
`sku_id`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`version`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`shape`  tinyint(4) NOT NULL ,
`style`  tinyint(4) NOT NULL ,
`disorder`  int(11) NOT NULL DEFAULT 0 ,
`isstate`  tinyint(4) NOT NULL DEFAULT 1 ,
`sendtime`  int(11) NOT NULL ,
 */
class Product extends Model
{
    const TABLE = 'product';
    const TABLE_ORDER = 'disorder desc,id asc';
    const TABLE_FIELD = 'id,big_img_path,cust_id,img_path,lens_refra_index,lens_type,market_price,mirr_width,nose_width,pay_type,prod_brand,prod_color,prod_material,prod_name,prod_series,prod_shape,prod_type,sku_id,version,shape,style';
}
