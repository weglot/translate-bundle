<?php
/**
 * @author Floran Pagliai
 * Date: 13/11/2017
 * Time: 10:48
 */

namespace Weglot\TranslateBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Weglot\TranslateBundle\Services\Parser;

class RequestListener implements EventSubscriberInterface
{
    private $parser;
    private $destination_languages;


    /**
     * RequestListener constructor.
     * @param Parser $parser
     * @var $destination_languages
     */
    public function __construct(Parser $parser, $destination_languages)
    {
        $this->parser = $parser;
        $this->destination_languages = $destination_languages;
    }


    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST  => array('onKernelRequest', 17),
            KernelEvents::RESPONSE => array('onKernelResponse'),
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        /* $request = $event->getRequest();
         if (!$request->hasPreviousSession()) {
             return;
         }
         if ($locale = $request->attributes->get('_locale')) {
             $request->setLocale($locale);
         } else {
             $request->setLocale($request->getLocale());
         }*/
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->getRequest()->isXmlHttpRequest()) {
            $request = $event->getRequest();
            $languageFrom = $request->getDefaultLocale();
            $languageTo = $request->getLocale();
            if ($languageFrom != $languageTo && in_array($languageTo,$this->destination_languages)) {
                $content = $event->getResponse()->getContent();
                $translatedContent = $this->parser->translateDomFromTo($content, $languageFrom, $languageTo);
                $event->getResponse()->setContent($translatedContent);
            }
        }
    }
}