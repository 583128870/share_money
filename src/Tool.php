<?php


namespace Sharemoney;



use Sharemoney\Role\RoleIm\Company;

/**
 * 格式化上级容器类
 * Class Tool
 * @package Sharemoney
 */
class Tool
{
    public $roleClass = [
        'ButlerHousekeeper',
        'CommonMember',
        'Company',
        'User',
        'VipMember'

    ];

    public $config = [
        'role_type' => 'role_type',
        'id' => 'id',
    ];

    public $roleObjectList = [];



    public function initData($parents)
    {

        foreach ($parents as $parent) {
            foreach ($this->roleClass as $role_class_name){
                $reflectionClass = new \ReflectionClass("Sharemoney\\Role\\RoleIm\\".$role_class_name);
                $role_object = $reflectionClass->newInstance();
                if ($parent[$this->config['role_type']] == $role_object->roleType){
                    $role_object->userInfo = $parent;
                    array_push($this->roleObjectList,$role_object);
                }
            }

        }
    }



    /**
     * 根据用户信息中的role_type 获取 当前角色对象
     * @param $userinfo
     */
    public function getUserRoleObject($userinfo){
        foreach ($this->roleClass as $role_class_name){
            $reflectionClass = new \ReflectionClass("Sharemoney\\Role\\RoleIm\\".$role_class_name);
            $role_object = $reflectionClass->newInstance();
            if ($userinfo[$this->config['role_type']] == $role_object->roleType){
                $role_object->userInfo = $userinfo;
               return $role_object;
            }
        }
    }
}