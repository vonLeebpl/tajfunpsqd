<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Wot\WotEvents;
use AppBundle\Entity\Clan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Wot\WotClans;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
/*        $defaultData = array('region' => 'EU');
        $form = $this->createFormBuilder($defaultData)
            ->add('region', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType',array(
                'choices' => array(
                    'EU' => 'EU',
                    'RU' => 'RU'
                ),
                'choices_as_values' => true,
                ))
            ->add('clantag', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('send', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
        }*/

        // ... render the form
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
       //     'form' => $form->createView(),
        ));
    }

    /**
    * @Route("/", name="clandata")
    * @Method("POST")
    */
    public function showclandataAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\FindClan');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
/*
            $wotclans = new WotClans();
            $wotclans->setRequestData(['search'=>$data['clantag']]);
            $wotclans->load();
*/

            $wotevents = new WotEvents();
/*
            $wotevents->setRequestData(['search'=>""]);
            $wotevents->load();
*/
            $wotevents->setRequestData(['accountinfo' => ['event_id'=>'safari','front_id'=>'1510_eu_event_front_1', 'account_id'=>'500451273']]);
            $wotevents->load();

        }
        return $this->render('default/index.html.twig', array(
            //     'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/refreshevents" )
     * @Method("GET")
     */
    public function refresheventsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wotevents = new WotEvents();

        $wotevents->setRequestData(['search'=>""]);
        $wotevents->load();
        $events = $wotevents->getData();

        $er = $em->getRepository('AppBundle:Event');
        foreach($events as $event)
        {
            $e = $er->findOneById($event->event_id);
            if (!$e) $e = new Event();

            $e->setId($event->event_id);
            $e->setEventName($event->event_name);
            $e->setStatus($event->status);
            $e->setStart(new \DateTime($event->start));
            $e->setEnd(new \DateTime($event->end));
            $fr= [];
            foreach($event->fronts as $front)
            {
                $fr[] = $front->front_id;
            }
            $e->setFronts((string)(implode(',',$fr)));

            $em->persist($e);
        }

        $rc = $em->getRepository('AppBundle:RefreshControler')->findOneById(1);
        $rc->setEventRefresh(new \DateTime('now'));

        $em->flush();

        return;
    }

    /**
     * @Route("/searchclan" )
     * @Method("POST")
     */
    public function searchClanAction()
    {
        //get post data from request
        //$request = $this->get('request');
        $clantag = $this->get('request')->request->get('clantag');

        //find matching clan from wot api
        $wc = new WotClans();
        $wc->setRequestData(['search'=>$clantag]);
        $wc->load();
        $clans = $wc->getData();

        return $this->render('default/searchclan.html.twig', array(
             'clans' => $clans,
        ));
    }

    /**
     * @Route("/show/{clan_id}" )
     * @Method("GET")
     */
    public function showClanAction($clan_id)
    {
        /*
         * Idea:
         * 1. check if clan exist in clans table
         * 2. check when it was last refreshed, 60 secs - TODO: make it configurable
         * 3. if there is a need load clan data:
         *      - remove clan and event data/members
         *      - load clan data and event data/members to db
         * 4. display template
         */
        $em = $this->getDoctrine()->getManager();

        // $clan should be null or Clan record
        $clan = $em->getRepository('AppBundle:Clan')->findOneById($clan_id);
        if (!$clan)
        {
            $wc = new WotClans();
            $wc->setRequestData(['detail'=>$clan_id]);
            $wc->load();

            $clan_data = $wc->getData()['info']->$clan_id;

            $clan = $em->getRepository('AppBundle:Clan')->getClanFromArray($clan_data);

            $em->getRepository('AppBundle:EventAccountData')->setClanMembersFromArray($clan,$clan_data->members);

            $em->persist($clan);
            $em->flush();
        }

        $event = $em->getRepository('AppBundle:Event')->findOneByStatus('ACTIVE');
        $event_id = $event->getId();


        $mdata = $em->getRepository('AppBundle:EventAccountData')->findByClan($clan_id);

        foreach ($mdata as $md)
        {
            // continue here
            // load wotapi eventaccountddetails
        }

/*
        //find matching clan from wot api
        $wc = new WotClans();
        $wc->setRequestData(['search'=>$clantag]);
        $wc->load();
        $clans = $wc->getData();*/

        return $this->render('default/showclan.html.twig', array(
            'event' => $event,
            'mdata' => $mdata,
            'clan' => $clan,
        ));
    }
}
