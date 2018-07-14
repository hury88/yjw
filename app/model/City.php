<?php
namespace App\model;
/*
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`title`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '城市名称' ,
`brand_ids`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' ,
`is_grab`  tinyint(4) NOT NULL DEFAULT 1 ,
`disorder`  int(11) NOT NULL DEFAULT 0 ,
`isstate`  tinyint(4) NOT NULL DEFAULT 1 ,
 */
class City extends Model
{
    const TABLE = 'city';
    const TABLE_ORDER = 'disorder desc, id asc';

    public function getGroupCitys()
    {
        $data = $this->select('id,title', $this->isGroupWhere());
        return $data;
    }
    public function getGrabCitys()
    {
        $data = $this->select('id,title', $this->isGrabWhere());
        return $data;
    }

    /**
     * @return 团车条件
     */
    private function isGroupWhere()
    {
        return 'isstate=1 and is_grab=0';
    }

    /**
     * @return 秒车条件
     */
    private function isGrabWhere()
    {
        return 'isstate=1 and is_grab=1';
    }
}