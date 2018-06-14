<?php

namespace CodeFlix\Listeners;

use CodeFlix\Models\PayPalWebProfile;
use CodeFlix\PayPal\WebProfileClient;
use Prettus\Repository\Events\RepositoryEntityDeleted;

class DeletePayPalWebProfileListener
{
    /**
     * @var WebProfileClient
     */
    private $webProfileClient;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(WebProfileClient $webProfileClient)
    {
        $this->webProfileClient = $webProfileClient;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityDeleted  $event
     * @return void
     */
    public function handle(RepositoryEntityDeleted $event)
    {
        $model = $event->getModel();
        if(!($model instanceof PayPalWebProfile)){
            return;
        }

        $this->webProfileClient->delete($model->code);
    }
}
