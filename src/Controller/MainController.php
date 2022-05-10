<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function main(
        \Doctrine\Bundle\MongoDBBundle\ManagerRegistry $mongoDb
    ): Response
    {
        $dm = $mongoDb->getManager();
        $list = $dm->createQueryBuilder('App:Client')->getQuery()->execute()->toArray(false);
        $count = $dm->createQueryBuilder('App:Client')->count()->getQuery()->execute();

        return new Response(
            '<html><body>Count of users: '.$count.'</body></html>'
        );
    }
}