<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Http\Requests\UserSettingRequest;
use CodeFlix\Repositories\UserRepository;
use CodeFlix\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UsersController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function updateSettings(UserSettingRequest $request)
    {
        $data = $request->only('password');
        $this->repository->update($data, $request->user('api')->id);

        return $request->user('api');
    }
}
