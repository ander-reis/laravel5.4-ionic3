<?php

namespace Tests\Feature\Api;

use Dingo\Api\Routing\UrlGenerator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTGuard;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * teste access token
     *
     * @return void
     */
    public function testAccessToken()
    {
        $this->makeJWTToken()
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * testa acesso não autorizado na api
     */
    public function testNotAuthorizedAccessApi()
    {
        $this->get('api/user')->assertStatus(500);
    }

    /**
     * testa refresh token
     */
    public function testRefreshToken()
    {
        // access token
        $testResponse = $this->makeJWTToken();

        // pega token
        $token = $testResponse->json()['token'];

        //dorme por 61 segundos, para expirar o token
        sleep(61);

        //desautentica user
        $this->clearAuth();

        // refresh token
        $testResponse = $this->get('api/user', [
            'Authorization' => "Bearer $token"
        ])->assertJsonStructure(['user' => ['name']]);

        //testa se token foi renovado
        $headers = $testResponse->baseResponse->headers;
        $bearerToken = $headers->get('Authorization');

        //compara tokens
        $this->assertNotEquals("Bearer $token", $bearerToken);

        //dorme por 31 segundos, para expirar o token
        sleep(31);

        //desautentica user
        $this->clearAuth();

        // verifica se token está na lista negra
        $this->get('api/user', [
            'Authorization' => "Bearer $token"
        ])->assertStatus(500);
    }

    /**
     * metodo para destruir autenticacao do usuario
     */
    protected function clearAuth()
    {
        // classe para manipular outras classe ou atributos, até private
        $reflectionClass = new \ReflectionClass(JWTGuard::class);

        // modifica a propriedade do user para null
        $reflectionProperty = $reflectionClass->getProperty('user');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(\Auth::guard('api'), null);

        //pega servico jwt para destruir token
        $jwt = app(JWT::class);
        $jwt->unsetToken();

        // desautentica usuario
        $dingoAuth = app(\Dingo\Api\Auth\Auth::class);
        $dingoAuth->setUser(null);
    }

    /**
     * faz teste no access token
     */
    protected function makeJWTToken()
    {
        //metodo para pegar rota na api, helper route não funciona em api
        $urlGenerator = app(UrlGenerator::class)->version('v1');

        //testa access token, status e estrutura json
        return $this->post($urlGenerator->route('api.access_token'), [
            'email' => 'admin@user.com',
            'password' => 'secret'
        ]);
    }
}
