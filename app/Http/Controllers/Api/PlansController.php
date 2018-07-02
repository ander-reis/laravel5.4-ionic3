<?php

namespace CodeFlix\Http\Controllers\Api;

use CodeFlix\Models\User;
use CodeFlix\Repositories\PlanRepository;
use CodeFlix\Http\Controllers\Controller;

class PlansController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $repository;
    /**
     * @var User
     */
    private $user;

    /**
     * PlansController constructor.
     */
    public function __construct(PlanRepository $repository, User $user)
    {
        $this->repository = $repository;
        $this->user = $user;
    }

    public function index()
    {
        return $this->repository->all();
    }
}
