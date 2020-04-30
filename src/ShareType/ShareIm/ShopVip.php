<?php


namespace Sharemoney\ShareType\ShareIm;


use Sharemoney\Role\RoleIm\ButlerHousekeeper;
use Sharemoney\Role\RoleIm\CommonMember;
use Sharemoney\Role\RoleIm\VipMember;
use Sharemoney\ShareType\ShareBase;
use Sharemoney\Tool;

/**
 * 购买超级会员
 * Class ShopVip
 * @package Sharemoney\ShareType\ShareIm
 */
class ShopVip extends ShareBase
{
    protected $from_user_info;
    //会员返现有效层级
    protected $share_member_level = 1;

    /**
     * 自身返利金额
     * @var int
     */
    protected $self_back_rule = 0;

    /**
     * 升级vip者是否返润,默认不返润
     * @var bool
     */
    protected $is_back_self = true;

    protected $rule = [
        3,
        2,
    ];

    public $share_object_list = [];

    public function shareMoney(Tool $tool, $share_rule = [], $from_user_info)
    {
        if (isset($share_rule['self_back_money'])) $this->self_back_money = $share_rule['self_back_money'];
        if (isset($share_rule['is_back_self'])) $this->is_back_self = $share_rule['is_back_self'];
        if (isset($share_rule['parent_back_money'])) $this->rule = $share_rule['parent_back_money'];
        $this->from_user_info = $from_user_info;
        $rule = $this->rule;
        $ButlerHousekeeper = new ButlerHousekeeper();
        if ($this->from_user_info[$tool->config['role_type']] == $ButlerHousekeeper->roleType) {//如果购买者是管家
            $ButlerHousekeeper->shareMoney = array_sum($this->rule);
            $ButlerHousekeeper->userInfo = $this->from_user_info;
            array_unshift($this->share_object_list, $ButlerHousekeeper);
        } else {
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
                        case 1: //如果只有一个会员返现
                            $role_object->shareMoney = array_sum($this->rule);
                            break;
                        case 0: //如果会员全部都有返现
                            $role_object->shareMoney = $this->rule[count($this->rule) - 1];
                            break;
                    }
                    array_unshift($this->share_object_list, $role_object);
                }
            }
        }

        /**
         * 自己返润
         */
        if($this->is_back_self){
            $from_user_object = $tool->getUserRoleObject($from_user_info);
            $from_user_object->shareMoney = $this->self_back_money;
            array_unshift($this->share_object_list, $from_user_object);
        }

    }
}