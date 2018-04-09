<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function accessToken(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->credentials($request);

        if($token = \Auth::guard('api')->attempt($credentials)){
            return $this->sendLoginResponse($request, $token);
        }

        /**
         * retorna erro no login
         */
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * retorna token
     * @param Request $request
     * @param $token
     * @return array
     */
    protected function sendLoginResponse(Request $request, $token)
    {
        return ['token' => $token];
    }

    /**
     * Altera a mensagem de erro caso os dados sejam invalido no login
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return response()->json([
            'error' => \Lang::get('auth.failed'),
            'status_code:' => 400
        ], 400);
    }

    /**
     * metodo invalida o token na lista negra
     * @param Request $request
     */
    public function logout(Request $request)
    {
        \Auth::guard('api')->logout();

        return response()->json([
            'status_code:' => 204
        ], 204);
    }

    /**
     * refresh token
     * @param Request $request
     * @return array
     */
    public function refreshToken(Request $request)
    {
        $token = \Auth::guard('api')->refresh();
        return $this->sendLoginResponse($request, $token);
    }
}
