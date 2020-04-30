<?php


namespace Sharemoney\ShareType\ShareIm;


use Sharemoney\Role\RoleIm\ButlerHousekeeper;
use Sharemoney\Role\RoleIm\CommonMember;
use Sharemoney\Role\RoleIm\VipMember;
use Sharemoney\ShareType\ShareBase;
use Sharemoney\Tool;

/**
 * 充值普通会员返润
 * Class Recharge
 * @package Sharemoney\ShareType\ShareIm
 */
class Recharge extends ShareBase
{
    //会员返现有效层级
    protected $share_member_level = 2;

    protected $rule = [
        100,
        20,
        10,
    ];

    public $share_object_list = [];

    public function shareMoney(Tool $tool, $share_rule = [], $from_user_info)
    {
        $this->rule = $share_rule['parent_back_money'];
        $rule = $this->rule;
        foreach ($tool->roleObjectList as $role_object) {
            //如果是普通会员或者vip会员
            if ($role_object instanceof VipMember || $role_object instanceof CommonMember) {
                if ($this->share_member_level > 0) {
                    $role_object->shareMoney = array_shift($rule);
                    $this->share_member_level--;
                    array_unshift($this->share_object_list, $role_object);
                }
                continue;
            }
            //如果是管家
            if ($role_object instanceof ButlerHousekeeper) {
                switch ($this->share_member_level) {
                    case 2: //如果没有会员返现
                        $role_object->shareMoney = $this->rule[0];

                        break;
                    case 1: //如果只有一个会员返现
                        $role_object->shareMoney = $this->rule[count($this->rule) - 1];
                        break;
                    case 0: //如果会员全部都有返现
                        $role_object->shareMoney = $this->rule[count($this->rule) - 1];;
                        break;
                }
                array_unshift($this->share_object_list, $role_object);
            }
        }
    }
}