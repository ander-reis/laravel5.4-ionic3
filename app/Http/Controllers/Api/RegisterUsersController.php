<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Http\Requests\UserRegisterRequest;
use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;
use Laravel\Socialite\Two\User;

class RegisterUsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * RegisterUsersController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    //metodo para registrar user
    public function store(UserRegisterRequest $request)
    {
        $user = $request->get('type') != '2' ? $this->storeFromFacebook($request) : $this->storeCommon($request);
        return ['token' => \Auth::guard('api')->tokenById($user->id)];
    }

    protected function storeCommon(Request $request)
    {
        \CodeFlix\Models\User::unguard();
        $user = $this->repository->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'role' => \CodeFlix\Models\User::ROLE_CLIENT,
            'verified' => true
        ]);
        $user = $this->repository->update([
            'password' => $request->get('password')
        ], $user->id);
        \CodeFlix\Models\User::reguard();
        return $user;
    }

    protected function storeFromFacebook(Request $request)
    {
        $authorization = $request->header('Authorization');
        $accessToken = str_replace('Bearer ', '', $authorization);
        $facebook = \Socialite::driver('facebook');
        /** @var User $userSocial */
        $userSocial = $facebook->userFromToken($accessToken);
        $user = $this->repository->findByField('email', $userSocial->email)->first();
        if(!$user){
            //desprotege models por cause do campo verified que não consta do filable
            \CodeFlix\Models\User::unguard();
            $user = $this->repository->create([
                'name' => $userSocial->name,
                'email' => $userSocial->email,
                'role' => \CodeFlix\Models\User::ROLE_CLIENT,
                'verified' => true
            ]);
            //retorna a proteão do models por cause do campo verified que não consta do filable
            \CodeFlix\Models\User::reguard();
        }
        return $user;
    }
}
