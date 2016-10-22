<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class SecurityController extends Controller
{

    public function registerAction(Request $request)
    {
        // Translator
        $t = $this->get('translator');
        
        // 1- Build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        // 2- Handle the submit (only happen in POST)
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // 3- Encode the password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            
            // Add basic role to the user
            $user->setRoles(array('ROLE_USER'));
            
            // The user begins disabled
            $user->setEnabled(FALSE);
            
            // 4- Save the User
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            // Send confirmation email
            $confirmationLink = $this->generateUrl(
                'activate', 
                array('id' => $user->getId()), 
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            $message = \Swift_Message::newInstance()
                ->setSubject($t->trans('Activate your account', array(), 'email'))
                ->setFrom('wodcitizen@gmail.com') // TODO: configure somewhere; why do I have to specify one if I have it configured on parameters.yml ?
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/registration.html.twig',
                        array('name' => $user->getName(), 'confirmationLink' => $confirmationLink)
                    ),
                    'text/html'
                )
                ->addPart(
                    $this->renderView(
                        'email/registration.txt.twig',
                        array('name' => $user->getName(), 'confirmationLink' => $confirmationLink)
                    ),
                    'text/plain'
                )
            ;
            
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('registration_sent');
        }
        
        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
        

    }
    
    public function activateUserAction($id) 
    {
        $success = TRUE;
        
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->find($id);
            
        if($user == NULL) {
            $this->addFlash(
                    'error',
                    "No user matching that activation code." // TODO: i18n
                );
        
            $success = FALSE;
        } elseif ($user->isEnabled()) {
            $this->addFlash(
                    'error',
                    "User is already active" // TODO: i18n
                );
        
            $success = FALSE;
        
        } else {
            $user->setEnabled(TRUE);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        
        return $this->render(
            'security/activate.html.twig',
            array( 'success' => $success )
        );
    }
    
    public function registrationSentAction() 
    {
        return $this->render('security/registration_sent.html.twig');
    }
    
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        // FIXME: change to email?
        $lastUsername = $authenticationUtils->getLastUsername();
        
        // Register link
        $registerLink = $this->generateUrl(
            'register', 
            array(),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        
        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_email' => $lastUsername,
                'error' => $error,
                'registerLink' => $registerLink,
                
            )
        );
    }

}
