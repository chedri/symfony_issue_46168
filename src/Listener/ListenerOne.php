<?php

namespace App\Listener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;

use App\Document\Client;

/**
 *
 */
class ListenerOne
{
    protected $whiteLabelWatcher;

    public function __construct(
        \App\Service\WhiteLabelWatcher $whiteLabelWatcher
    ) {
        $this->whiteLabelWatcher = $whiteLabelWatcher;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postLoad
        ];
    }

    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        if (
            $eventArgs->getDocument() instanceof Client
        ) {
            $eventArgs->getDocument()->getIsActive();
        }
    }
}
