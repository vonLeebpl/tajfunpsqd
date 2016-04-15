<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Clan;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use AppBundle\Wot\WotConfig;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        return $this->render('default/index.html.twig', array(
        ));
    }

    /**
     * @Route("/refreshevents" )
     * @Method("GET")
     */
    public function refresheventsAction()
    {
        $ws = $this->get('app.wot_service');
        $ws->refreshEvents();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/searchclan" )
     * @Method("POST")
     */
    public function searchClanAction(Request $request)
    {
        //get post data from request
        $clantag = $request->get('clantag');

        $ws = $this->get('app.wot_service');
        $clans = $ws->findClans($clantag);

        return $this->render('default/searchclan.html.twig', array(
             'clans' => $clans,
        ));
    }

    /**
     * @Route("/noactive", name="noactiveevent" )
     * @Method("GET")
     */
    public function noActiveEventAction()
    {
        return $this->render('default/noactiveevent.html.twig');
    }

    /**
     * @Route("/show/{clan_id}", defaults={"event_id": null}, name="showclanactiveevent")
     * @Route("/show/{clan_id}/{event_id}", name="showclanevent" )
     * @Method("GET")
     */
    public function showClanAction($clan_id, $event_id)
    {
        $em = $this->getDoctrine()->getManager();

        // find out if we have active event in case event_id is null
        $refresh_event = ($em->getRepository('AppBundle:Event')->findOneById($event_id) ?: $em->getRepository('AppBundle:Event')->isActiveEvent());

        if (!$refresh_event) return $this->redirectToRoute('noactiveevent');

        // $clan should be null or Clan record
        $clan = $em->getRepository('AppBundle:Clan')->findOneById($clan_id);
        $load = false;
        if ($clan) {
            // check if we have to refresh clan data
            //$t = new \DateTime('now');
            if (time() - ($clan->getLastUpdated()->getTimeStamp()) > WotConfig::$refresh_interval) {
                //remove data from tables
                $em->remove($clan);
                $em->flush();
                $load = true;
            }
        }
        if (!$clan or $load)
        {
            // now load data
            $wot_service = $this->get('app.wot_service');
            $wot_service->refreshClanEventData($clan_id, $refresh_event);

            $clan = $em->getRepository('AppBundle:Clan')->findOneById($clan_id);
        }
        $mdata = $em->getRepository('AppBundle:EventAccountData')->findBy(array('clan' => $clan->getId(), 'event' => $refresh_event->getId()), array('fame_points' => 'DESC'));

        return $this->render('default/showclan.html.twig', array(
            'event' => $refresh_event,
            'mdata' => $mdata,
            'clan' => $clan,
        ));
    }
}
