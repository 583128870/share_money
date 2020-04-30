<?php
namespace Sharemoney\Role;
/**
 * 角色抽象类
 * Class RoleBase
 * @package Sharemoney\Role
 */
abstract  class RoleBase{

    public $userInfo;

    /**
     * 角色类型
     * @var int
     */
   public $roleType;

    /**
     * 角色名称
     * @var  string
     */
    public $roleName;

    /**
     * 分润金额
     * @var double
     */
    public $shareMoney = 0;

  

}
