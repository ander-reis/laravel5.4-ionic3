<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//Route::get('/test', function(){
//    return ['message' => 'Hello World API'];
//});

\ApiRoute::version('v1', function () {
    ApiRoute::group([
        'namespace' => 'CodeFlix\Http\Controllers\Api',
        'as' => 'api',
        'middleware' => 'bindings'
        ], function () {
        //access token
        ApiRoute::post('/access_token', [
            'uses' => 'AuthController@accessToken',
            'middleware' => 'api.throttle',
            'limit' => 10,
            'expires' => 1
        ])->name('.access_token');

        //refresh token
        ApiRoute::post('/refresh_token', [
            'uses' => 'AuthController@refreshToken',
            'middleware' => 'api.throttle',
            'limit' => 10,
            'expires' => 1
        ])->name('.refresh_token');

        //rota para registrar user facebook
        ApiRoute::post('/register', 'RegisterUsersController@store');

        ApiRoute::group([
            'middleware' => ['api.throttle', 'api.auth'],
            'limit' => 100,
            'expires' => 3],
            function () {
                //logout
                ApiRoute::post('/logout', 'AuthController@logout');

                // rota para test phpunit
                ApiRoute::get('/user', function (Request $request){
                    /**
                     * 3 metodos para retonar user autenticado
                     */
                    return $request->user('api');
                    //return app(\Dingo\Api\Auth\Auth::class)->user();
                    //return \Auth::guard('api')->user();
                });

                //rota para atualizar password
                ApiRoute::patch('/user/settings', 'UsersController@updateSettings');

                //rota para cpf
                ApiRoute::patch('/user/cpf', 'UsersController@addCpf');

                //rota plans
                ApiRoute::get('/plans', 'PlansController@index');

                //rota payments
                ApiRoute::post('/plans/{plan}/payments', 'PaymentsController@store');

                //grupo assinante protegido pelo middleware check-subscription
                ApiRoute::group(['middleware' => 'check-subscriptions'], function(){
                    //rota test
                    ApiRoute::get('/test', function () {
                        return 'teste de validade subscription';
                    });
                });
            });
    });
});