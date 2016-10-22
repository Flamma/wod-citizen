<?php

namespace AppBundle\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class for making the session sticky.
 *
 * As in http://symfony.com/doc/current/cookbook/session/locale_sticky_session.html
 * but instead of having a default locale, use the preferred language as it.
 *
 */
class LocaleListener implements EventSubscriberInterface
{
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if(!$request->hasPreviousSession()) {
            $this->setPreferredLocale($request);
            return;
        }
        
        // try to see if the locale has been set as a _locale routing parameter
        if( $locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            // if no explicit locale has been set on this request, 
            // use one from the session
            $locale = $request->getSession()->get('locale', NULL);
            
            if($locale != NULL) {
                $request->setLocale($locale);
            } else {
                $locale = $this->setPreferredLocale($request);
                $request->getSession()->set('locale', $locale);
            }
        }
    }
    
    private function setPreferredLocale(Request $request)
    {
        $request->setLocale($request->getPreferredLanguage());
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            // must be registered after the default Locale listener
            KernelEvents::REQUEST => array(array('onKernelRequest', 15)),
        );
    }
}

?>
