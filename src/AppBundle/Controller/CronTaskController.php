<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\CronTask;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/crontasks")
 */
class CronTaskController extends Controller
{
    /**
     * @Route("/test", name="crontasks_test")
     */
    public function testAction()
    {
        $entity = new CronTask();

        $entity
            ->setName('PSQD clans refresh')
            ->setInterval(300) // Run once every 5 mins
            ->setCommands([
                    'wot:refresh_clan_data 500021712',
                    'wot:refresh_clan_data 500028148',
                    'wot:refresh_clan_data 500033844',
                    'wot:refresh_clan_data 500014168',
                ]
            );

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return new Response('OK!');
    }
}
