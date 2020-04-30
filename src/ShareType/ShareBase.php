<?php

namespace Sharemoney\ShareType;
use Sharemoney\Role\RoleBase;
use Sharemoney\Tool;

abstract class ShareBase
{
    /**
     * 返现规则
     * @var
     */
  protected $rule;


    /**
     * 执行返现
     * @param RoleBase $roleObject
     * @return mixed
     */
  public abstract function shareMoney(Tool $tool,$share_rule,$from_user_info);
}