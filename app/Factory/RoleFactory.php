<?php


namespace App\Factory;


use App\Constant\RoleConstant;
use App\Models\User;

class RoleFactory
{

    public static function checkRoleOfUser($role_name)
    {
        if ( ! in_array($role_name, RoleConstant::ROLE_NAME_ALL)) {

            logger(sprintf('ERROR! role name %s not exists', $role_name));

            return false;
        }

        $data = User::with('roles')->whereId(auth()->user()->id)->first()->toArray();

        $role = $data['roles'];

        if (empty($role)) {

            logger(sprintf('ERROR! role name %s not exists', $role_name));

            return false;
        }

        $is_has_key_role = array_search($role_name, array_column($role, 'name_column'));

        if ($is_has_key_role === false) {

            logger(sprintf('ERROR! role name %s not exists', $role_name));

            return false;
        }

        return true;
    }
}
