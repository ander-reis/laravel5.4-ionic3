<?php

namespace CodeFlix\Http\Controllers;

use CodeFlix\Repositories\UserRepository;
use Illuminate\Http\Request;
use Jrean\UserVerification\Traits\VerifiesUsers;

class EmailVerificationController extends Controller
{
    /**
     * trait jrean/verification
     */
    use VerifiesUsers;
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * EmailVerification constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function redirectAfterVerification()
    {
        $this->loginUser();
//        return url('/admin/dashboard');

        //redirecion user para cadastrar password
        return url('/admin/users/settings');
    }

    protected function loginUser(){
        $email = \Request::get('email');
        $user = $this->repository->findByField('email', $email)->first();
        \Auth::login($user);
    }
}
