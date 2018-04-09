<?php

namespace Tests\Feature\Admin;

use CodeFlix\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfUserDoesntSeeUserList()
    {
        //testa rota login com redirecionamento não autenticado
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('admin.login'))
            ->assertStatus(302);
    }

    public function testIfUserSeeUserList()
    {
        //desabilita fillable do model
        Model::unguard();

        //cria usuário no sqlite na memoria
        $user = factory(User::class)->states('admin')->create(['verified' => true]);

        //testa usuario autenticado
        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertSee('Listagem de Usuários');

        $this->get(route('admin.users.index'))
            ->assertSee('Listagem de Usuários');
    }
}
