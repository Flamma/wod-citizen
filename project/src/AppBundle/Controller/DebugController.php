<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\User;
use AppBundle\Entity\Character;
use AppBundle\Entity\Game;

class DebugController extends Controller
{
    public function populateAction() 
    {
        // TODO: move to somewhere more appropriate
        $users = array();
        $characters = array();
        
        $user = new User();
        $user->setName('Pablo');
        $user->setEmail('pablo@generator.net');
        $user->setPassword('');
        $user->addCharacter(new Character('Pilgrim'));
        $user->addCharacter(new Character('Salim'));

/*
        $character = new Character("Pilgrim");
        $character->setUser($user);
        $characters[] = $character;
        $character = new Character("Salim");
        $character->setUser($user);
        $characters[] = $character;
*/        
        $users[] = $user;
        
        $user = new User();
        $user->setName('Manolo');
        $user->setEmail('manolo@generator.net');
        $user->setPassword('');
        $user->addCharacter(new Character('Ingrid'));
        $user->addCharacter(new Character('Lorena'));

/*
        $character = new Character("Ingrid");
        $character->setUser($user);
        $characters[] = $character;
        $character = new Character("Lorena");
        $character->setUser($user);
        $characters[] = $character;
*/        
        $users[] = $user;
        
        $games = array();
        
        $games[] = new Game('vampire', 'Vampire: the Masquerade');
        $games[] = new Game('werewolf', 'Werewolf: the Apocalypse');
        $games[] = new Game('mage', 'Mage: the Ascension');
        $games[] = new Game('wraith', 'Wraith: the Oblivion');
        $games[] = new Game('changeling', 'Changeling: the Dreaming');
        
        
        $em = $this->getDoctrine()->getManager();
        foreach($users as $user) {

            foreach($user->getCharacters() as $character)
                $em->persist($character);
                
            $em->persist($user);
            
        }       
        
        foreach($characters as $character)
            $em->persist($character); 
            
        foreach($games as $game)
            $em->persist($game);
        
        $em->flush();
                
        return $this->render(
            'debug/populate.html.twig',
            array(
                'users' => $users
            )
        );
        
        
        
    }

    public function showUserAction($userpar)
    {
        $users = array();
        
        if($userpar != NULL) {
            // Try to find by id
            $user = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->find($userpar);
                
            if($user == NULL) {
                // Try to find by name
                $user = $this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->findOneByName($userpar);
            }
            
            if($user != NULL)
                $users[] = $user;
        
        } else {
            // No parameter specified, bring all users
            $users = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->findAll();           
        }
                
        return $this->render(
            'debug/user.html.twig',
            array(
                'users' => $users
            )
        );
    
    }
    
    
}
