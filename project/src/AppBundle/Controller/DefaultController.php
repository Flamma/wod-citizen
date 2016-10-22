<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Chronicle;
use AppBundle\Form\ChronicleType;
use AppBundle\Entity\StorytellerMembership;
use AppBundle\Entity\PlayerMembership;
use AppBundle\Form\MembershipType;


class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // Translator
        $t = $this->get('translator');

        $userName = $t->trans('Guest');
        $chronicles = null;
        if($this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY')
        ){
            $user = $this->getUser();
            $userName = $user->getName();

            $chronicles = array();
            foreach($user->getMemberships() as $membership) {
                $chronicles[] = $membership->getChronicle();
            }

        }

        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'userName' => $userName,
            'chronicles' => $chronicles,
        ]);
    }

    public function newChronicleAction(Request $request)
    {
        // Get the user
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        // Build the form
        $chronicle = new Chronicle($user);
        $membership = new StorytellerMembership($user, $chronicle);
        $form = $this->createForm(ChronicleType::class, $chronicle);

        // Handle the submit
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chronicle);
            $em->persist($membership);
            $em->flush();

            return $this->render(
                'default/chronicle-created.html.twig',
                array('chronicle_name' => $chronicle->getName())
            );
        }


        return $this->render(
            'default/new-chronicle.html.twig',
            array('form' => $form->createView())
        );
    }

    public function viewChronicleAction($id, Request $request)
    {
        // Translator
        $t = $this->get('translator');

        // Get the user
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        // Find the chronicle among user memberships
        $memberships = $user->getMemberships();
        $chronicle = NULL;
        $membership = NULL;
        $i = 0;
        while ( ($i < count($user->getMemberships())) && ($chronicle == NULL) ) {
            $membership = $memberships[$i];

            if($membership->getChronicle()->getId()==$id)
                $chronicle = $membership->getChronicle();

            $i++;
        }

        // TODO: if user admin find chronicle among all chronicles ?
        $userIsSt = is_a($membership, StorytellerMembership::class);

        $storytellers = array();
        $players = array();
        if( $chronicle !== NULL) {
            foreach($chronicle->getMemberships() as $membership) {

                if(is_a($membership, StorytellerMembership::class))
                    $storytellers[] = $membership->getUser();
                else
                    $players[] = $membership->getUser();
            }
        }



        return $this->render(
            'default/view-chronicle.html.twig',
            array(
                'chronicle' => $chronicle,
                'storytellers' => $storytellers,
                'players' => $players,
                'userIsSt' => $userIsSt,
            )
        );

    }

    public function addPlayerToChronicleAction($id, Request $request)
    {
        // Translator
        $t = $this->get('translator');

        // Get the user
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        // Find the chronicle among user memberships
        $memberships = $user->getMemberships();
        $chronicle = NULL;
        $membership = NULL;
        $i = 0;
        while ( ($i < count($user->getMemberships())) && ($chronicle == NULL) ) {
            $membership = $memberships[$i];

            if($membership->getChronicle()->getId()==$id)
                $chronicle = $membership->getChronicle();

            $i++;
        }

        // TODO: if user admin find chronicle among all chronicles ?
        $userIsSt = is_a($membership, StorytellerMembership::class);

        if(!$userIsSt) {
            // TODO: abort process
        }

        $storytellers = array();
        $players = array();
        if( $chronicle !== NULL) {
            foreach($chronicle->getMemberships() as $membership) {

                if(is_a($membership, StorytellerMembership::class))
                    $storytellers[] = $membership->getUser();
                else
                    $players[] = $membership->getUser();
            }
        }
        $allPlayers = array_merge($storytellers, $players);

        // FIXME: find a good way to add users instead of listing them (friends, email,...)
        $candidates = array();
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        foreach ($users as $newUser) {

            if(!in_array($newUser, $allPlayers)) {
                $candidates[] = $newUser;
            }
        }

        // Build the form
        $membership = new PlayerMembership(null, $chronicle); // TODO: allow to select membership type
        $form = $this->createForm(MembershipType::class, $membership, array('candidates' => $candidates));

        // Handle the submit
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($membership);
            $em->flush();

            return $this->render(
                'default/player-added.html.twig',
                array('chronicle_name' => $membership->getChronicle()->getName(),
                    'player_name' => $membership->getUser()->getName(),
                    'chronicle_id' => $membership->getChronicle()->getId())
            );
        }


        return $this->render(
            'default/add-player-to-chronicle.html.twig',
            array(
                'form' => $form->createView(),
                'chronicle_id' => $membership->getChronicle()->getId(),
            )
        );


    }

    public function addFriendAction(Request $request)
    {
        // Translator
        $t = $this->getTranslator();

        // Get the user
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

    }

}
