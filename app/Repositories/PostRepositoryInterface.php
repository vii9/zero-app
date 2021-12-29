<?php


namespace App\Repositories;


interface PostRepositoryInterface
{
    public function getPostByUserHasRole($role_name);
    public function getPostById($id);
}
