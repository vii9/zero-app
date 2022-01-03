<?php

namespace App\Http\Controllers\Api;

use App\Constant\ApiStatus;
use App\Http\Controllers\Controller;
use App\Repositories\UserApiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthSanctumController extends Controller
{
    /**
     * @var UserApiRepositoryInterface
     */
    private $_userRepo;


    public function __construct(UserApiRepositoryInterface $userRepository)
    {
        $this->_userRepo = $userRepository;
    }

    /**
     *
     *@description create token by user, check it in personal_access_tokens table
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->_validateUserCreate($request->all());

        if ($validator->fails()) {
            return apiError(ApiStatus::VALIDATE_ERROR, $validator->getMessageBag());
        }

        try {
            $user = $this->_userRepo->createUser($request->all());

            $userToken = $user->createToken('u_token')->plainTextToken;

            return apiSuccess(['user' => $user, 'user_token' => $userToken], 'user created! oke', ApiStatus::CREATED);
        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'can not create user!');
        }
    }

    private function _validateUserCreate($request)
    {
        return Validator::make($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|unique:users,email|max:191',
            'password' => 'required|string|confirmed|max:191',
        ],[
            'name.required' => 'Tên người dùng thì bắt buộc'
        ]);
    }

    public function login(Request $request)
    {
        $validator = $this->_validateUserLogin($request->all());

        if ($validator->fails()) {
            return apiError(ApiStatus::VALIDATE_ERROR, $validator->getMessageBag());
        }

        try {
            $user = $this->_userRepo->getUserByEmail($request->email);

            if (! $user or ! Hash::check($request->password, $user->password)) {
                return apiError(ApiStatus::CREDENTIAL_ERROR, 'email or password invalid!');
            }

            $userToken = $user->createToken('u_token')->plainTextToken;

            return apiSuccess(['user' => $user, 'user_token' => $userToken], 'Login successfully!');
        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'Login fails');
        }
    }

    private function _validateUserLogin($request)
    {
        return Validator::make($request, [
            'email' => 'required|string|email|max:191',
            'password' => 'required|string|max:191',
        ]);
    }

    public function logout(Request $request)
    {
        $user_id = (int) $request->user_id;
        $_user_id = (int) auth()->user()->tokens()->pluck('tokenable_id')[0];

        if ($user_id !== $_user_id) {
            return apiError(ApiStatus::SERVER_ERROR, 'Can not logout: Token Invalid!');
        }

        try {
            auth()->user()->tokens()->delete();

            return apiSuccess([], 'Logout successfully!');
        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'Can not logout: Token Invalid');
        }
    }
}
