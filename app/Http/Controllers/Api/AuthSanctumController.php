<?php

namespace App\Http\Controllers\Api;

use App\Constant\ApiStatus;
use App\Http\Controllers\Controller;
use App\Repositories\UserApiRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiRoleHelper;


class AuthSanctumController extends Controller
{
    use ApiRoleHelper;

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

            $userToken = $user->createToken($request->device_name)->plainTextToken;

            return apiSuccess([
                'user' => $user, 'user_token' => $userToken, 'device_name' => $request->device_name
            ], 'user created! oke', ApiStatus::CREATED);
        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'can not create user!');
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function _validateUserCreate($request)
    {
        return Validator::make($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|unique:users,email|max:191',
            'password' => 'required|string|confirmed|max:191',
            'device_name' => 'required',
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

            $userToken = $user->createToken($request->device_name)->plainTextToken;

            return apiSuccess([
                'user' => $user, 'user_token' => $userToken, 'device_name' => $request->device_name
            ], 'Login successfully!');
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
            'device_name' => 'required',
        ]);
    }

    /**
     * @param Request $request
     * @required user_id, current_token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user_id = (int) $request->user_id;
        $_user_id = (int) auth()->user()->tokens()->pluck('tokenable_id')[0];

        if ( ! is_integer($user_id) || $user_id !== $_user_id) {
            return apiError(ApiStatus::SERVER_ERROR, 'Can not logout: Token Invalid!');
        }

        try {
            // logout only 1 { browse|device }
            auth()->user()->tokens()->where('id', $this->_getIdAccessToken($request->current_token))->delete();

            return apiSuccess([], 'Logout successfully!');
        } catch (\Exception $e) {
            logger($e->getMessage());

            return apiError(ApiStatus::SERVER_ERROR, 'Can not logout: Token Invalid');
        }
    }

    private function _getIdAccessToken($client_token_auth)
    {
        return explode("|", $client_token_auth)[0];
    }

    public function profile()
    {
        return apiSuccess([
            'is_admin' => $this->userHasRoleCEO(),
            'is_editor' => $this->userHasRoleEditor(),
            'is_author' => $this->userHasRoleAuthor(),
        ]);
    }
}
