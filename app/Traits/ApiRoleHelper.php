<?php

namespace App\Traits;
use App\Constant\RoleConstant;
use App\Factory\RoleFactory;

trait ApiRoleHelper {

    protected function userHasRoleCEO()
    {
        return RoleFactory::checkRoleOfUser(RoleConstant::IS_CEO);
    }

    protected function userHasRoleEditor()
    {
        return RoleFactory::checkRoleOfUser(RoleConstant::IS_EDITOR);
    }

    protected function userHasRoleAuthor()
    {
        return RoleFactory::checkRoleOfUser(RoleConstant::IS_AUTHOR);
    }
}
