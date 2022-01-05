<?php


namespace App\Repositories;


interface UserApiRepositoryInterface
{
    public function createUser($data);
    public function getUserByEmail($email);
}
