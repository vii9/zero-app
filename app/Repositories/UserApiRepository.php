<?php


namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserApiRepository implements UserApiRepositoryInterface
{
    /**
     * @var User
     */
    private $_userModel;


    public function __construct(User $user)
    {
        $this->_userModel = $user;
    }

    public function createUser($data)
    {
        return $this->_userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function getUserByEmail($email)
    {
        return $this->_userModel->whereEmail($email)->first();
    }

    public function getUsersByRole($role_name)
    {
        return $this->_userModel->whereHas('roles', function ($query) use ($role_name) {
            $query->where('roles.name_column', '=', $role_name);
        })->select('email', 'id')->get();
    }
}
