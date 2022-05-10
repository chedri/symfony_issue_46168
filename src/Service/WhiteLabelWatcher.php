<?php

namespace App\Service;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;
use Doctrine\ODM\MongoDB\Events;

use App\Document\Client;

/**
 *
 */
class WhiteLabelWatcher
{
    public function __construct(
        \Doctrine\Bundle\MongoDBBundle\ManagerRegistry $mongoDb,
        \Symfony\Component\HttpFoundation\RequestStack $requestStack,
    )
    {
        $settings = $mongoDb->getManager()->createQueryBuilder('App:WhiteLabelSettings')
            ->getQuery()->getSingleResult()
            ;
        $settings->getIsActive();

        if ($requestStack->getCurrentRequest() !== null) {
            $requestStack->getCurrentRequest()->getHost();
        }
    }
}
