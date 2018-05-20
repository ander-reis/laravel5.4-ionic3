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
    ApiRoute::group(['namespace' => 'CodeFlix\Http\Controllers\Api', 'as' => 'api'], function () {
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

                //rota test
                ApiRoute::get('/test', function () {
                    return 'api teste';
                });

                // rota para test phpunit
                ApiRoute::get('/user', function (Request $request){
                    /**
                     * 3 metodos para retonar user autenticado
                     */
                    return $request->user('api');
                    //return app(\Dingo\Api\Auth\Auth::class)->user();
                    //return \Auth::guard('api')->user();
                });
            });
    });
});