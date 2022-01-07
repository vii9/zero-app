<?php

namespace App\Traits;
use App\Constant\RoleConstant;
use App\Factory\RoleFactory;

trait ApiRoleHelper {

    protected function isUserHasRoleCEO()
    {
        return RoleFactory::checkRoleOfUser(RoleConstant::IS_CEO);
    }

    protected function isUserHasRoleEditor()
    {
        return RoleFactory::checkRoleOfUser(RoleConstant::IS_EDITOR);
    }

    protected function isUserHasRoleAuthor()
    {
        return RoleFactory::checkRoleOfUser(RoleConstant::IS_AUTHOR);
    }
}
