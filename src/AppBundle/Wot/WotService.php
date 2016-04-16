<?php
/**
 * Created by PhpStorm.
 * User: JPa
 * Date: 2016-04-14
 * Time: 21:44
 */

namespace AppBundle\Wot;

use AppBundle\Entity\Event;
use Doctrine\ORM\EntityManager;


class WotService
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function refreshClanEventData($clan_id, $event)
    {

        // call WOT API
        $wc = new WotClans();
        $wc->setRequestData(['detail'=>$clan_id]);
        $wc->load();
        $clan_data = $wc->getData()['info'][$clan_id];

        // parse clan data array
        $clan = $this->em->getRepository('AppBundle:Clan')->getClanFromArray($clan_data);

        // parse clan members data array
        $this->em->getRepository('AppBundle:EventAccountData')->setClanMembersFromArray($clan,$clan_data['members']);

        $this->em->persist($clan);
        $this->em->flush();


        $mdata = $this->em->getRepository('AppBundle:EventAccountData')->findByClan($clan_id);

        foreach ($mdata as $md)
        {
            // load wotapi eventaccountddetails
            $ev = new WotEvents();
            $ev->setRequestData(['accountinfo' => [
                'event_id' => $event->getId(),
                'front_id' => $event->getFronts(),
                'account_id' => $md->getAccountId()
            ]]);
            $ev->load();

            /*
             * strucure of info:
             * account_id
             *  ->'events'
             *      ->event_id
             *          ->[0]
             */
            $info = $ev->getData();

            $ii = $info[$md->getAccountId()]['events'];

            $this->em->getRepository('AppBundle:EventAccountData')->setEventDataFromArray($md, $ii);
            $this->em->persist($md);
        }
        $this->em->flush();
    }

    public function refreshEvents()
    {
        $wotevents = new WotEvents();

        $wotevents->setRequestData(['search'=>""]);
        $wotevents->load();
        $events = $wotevents->getData();

        $er = $this->em->getRepository('AppBundle:Event');
        foreach($events as $event)
        {
            $e = $er->findOneById($event['event_id']);
            if (!$e) $e = new Event();

            $e->setId($event['event_id']);
            $e->setEventName($event['event_name']);
            $e->setStatus($event['status']);
            $e->setStart(new \DateTime($event['start']));
            $e->setEnd(new \DateTime($event['end']));
            $fr= [];
            foreach($event['fronts'] as $front)
            {
                $fr[] = $front['front_id'];
            }
            $e->setFronts((string)(implode(',',$fr)));

            $this->em->persist($e);
        }

        $this->em->flush();
    }

    public function findClans($clantag)
    {
        //find matching clan from wot api
        $wc = new WotClans();
        $wc->setRequestData(['search'=>$clantag]);
        $wc->load();
        return $wc->getData();
    }


}