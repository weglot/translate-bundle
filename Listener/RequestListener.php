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

    /**
     * RequestListener constructor.
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
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
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        } else {
            $request->setLocale($request->getLocale());
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->getRequest()->isXmlHttpRequest()) {
            $request = $event->getRequest();
            $languageFrom = $request->getDefaultLocale();
            $languageTo = $request->getLocale();
            if ($languageFrom != $languageTo) {
                $content = $event->getResponse()->getContent();
                $translatedContent = $this->parser->translateDomFromTo($content, $languageFrom, $languageTo);
                $event->getResponse()->setContent($translatedContent);
            }
        }
    }
}