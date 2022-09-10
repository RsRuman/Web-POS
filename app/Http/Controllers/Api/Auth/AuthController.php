<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\UserResource;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{

    /**
     * Client login API
     * @param Request $request
     * @return JsonResponse
     */
    #Login
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:55',
            'password' => 'required|min:8|max:15'
        ]);

        if ($validator->fails()){
            return validation_response($validator->errors()->getMessages());
        }

        $user = User::where('email', $request->input('email'))->isActive()->first();
        if (empty($user)){
            return json_response('Failed', ResponseAlias::HTTP_UNAUTHORIZED, '', 'Your account is currently inactive. Please contact with Paymaster', false);
        }

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {
            $user = Auth::user()->load(['roles', 'business_organization']);
            $token = $user->createToken('PayMaster')->accessToken;
            $user = new UserResource($user);
            $data = [
                'token' => $token,
                'user' => $user,
            ];

            return json_response('Success', ResponseAlias::HTTP_OK, $data, 'You have been successfully log in', true);
        }
        return json_response('Failed', ResponseAlias::HTTP_UNAUTHORIZED, '', 'Wrong Credentials', false);
    }

    /**
     * Client Logout API
     * @param Request $request
     * @return JsonResponse
     */
    #Logout
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user('api')->token();
        $token->revoke();
        return json_response('Success', ResponseAlias::HTTP_OK, '', 'You have been successfully logged out!', true);
    }
}
