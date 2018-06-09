<?php

namespace CodeFlix\Listeners;

use CodeFlix\Models\PayPalWebProfile;
use CodeFlix\PayPal\WebProfileClient;
use CodeFlix\Repositories\PayPalWebProfileRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;

class CreatePayPalWebProfileListener
{
    /**
     * @var WebProfileClient
     */
    private $webProfileClient;
    /**
     * @var PayPalWebProfileRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WebProfileClient $webProfileClient, PayPalWebProfileRepository $repository)
    {
        //
        $this->webProfileClient = $webProfileClient;
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityCreated  $event
     * @return void
     */
    public function handle(RepositoryEntityCreated $event)
    {
        $model = $event->getModel();
        if(!($model instanceof PayPalWebProfile)){
            return;
        }

        $payPalWebProfile = $this->webProfileClient->create($model);
        \Config::set('webprofile_created', true);
        $this->repository->update([
            'code' => $payPalWebProfile->getId()
        ], $model->id);
    }
}
