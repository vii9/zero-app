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
            return response()->json([
                'app_message' => 'ERROR', 'data' => $validator->getMessageBag()
            ], ApiStatus::VALIDATE_ERROR);
        }

        try {
            $user = $this->_userRepo->createUser($request->all());

            $userToken = $user->createToken('u_token')->plainTextToken;

            return response()->json([
                'app_message' => 'SUCCESS',
                'data' => [
                    'user' => $user,
                    'user_token' => $userToken
                ]
            ], ApiStatus::CREATED);
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json([
                'app_message' => 'ERROR', 'data' => 'Can not create user'
            ], ApiStatus::SERVER_ERROR);
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
            return response()->json([
                'app_message' => 'ERROR', 'data' => $validator->getMessageBag()
            ], ApiStatus::VALIDATE_ERROR);
        }

        try {
            $user = $this->_userRepo->getUserByEmail($request->email);

            if (! $user or ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'app_message' => 'ERROR', 'data' => 'email or password invalid!'
                ], ApiStatus::CREDENTIAL_ERROR);
            }

            $userToken = $user->createToken('u_token')->plainTextToken;

            return response()->json([
                'app_message' => 'SUCCESS',
                'data' => [
                    'user' => $user,
                    'user_token' => $userToken
                ]
            ], ApiStatus::CREATED);
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json([
                'app_message' => 'ERROR', 'data' => 'Can not create user'
            ], ApiStatus::SERVER_ERROR);
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
            return response()->json(['app_message' => 'ERROR', 'data' => 'Can not logout: Token Invalid!'], ApiStatus::SERVER_ERROR);
        }

        try {
            auth()->user()->tokens()->delete();

            return response()->json([
                'app_message' => 'SUCCESS',
                'data' => ['user_token' => 'Logout successfully!']
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());

            return response()->json(['app_message' => 'ERROR', 'data' => 'Can not logout: Token Invalid'], ApiStatus::SERVER_ERROR);
        }
    }
}
