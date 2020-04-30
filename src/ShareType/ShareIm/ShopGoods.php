<?php


namespace Sharemoney\ShareType\ShareIm;


use Sharemoney\Role\RoleIm\ButlerHousekeeper;
use Sharemoney\Role\RoleIm\CommonMember;
use Sharemoney\Role\RoleIm\VipMember;
use Sharemoney\ShareType\ShareBase;
use Sharemoney\Tool;

/**
 * 商城购物体系返run
 * Class ShopGoods
 * @package Sharemoney\ShareType\ShareIm
 */
class ShopGoods extends ShareBase
{


    protected $rule = [
        5
    ];

    public $share_object_list = [];

    public function shareMoney(Tool $tool, $share_rule = [], $from_user_info)
    {
        if (isset($share_rule['parent_back_money'])) $this->rule = $share_rule['parent_back_money'];
        foreach ($tool->roleObjectList as $role_object) {
            if ($role_object instanceof ButlerHousekeeper) {
                $role_object->shareMoney = array_sum($this->rule);
                array_unshift($this->share_object_list, $role_object);
            }
        }


    }
}