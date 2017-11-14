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
            KernelEvents::REQUEST  => array('onKernelRequest', 100),
            KernelEvents::RESPONSE => array('onKernelResponse'),
        );
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        // TODO : check route requested, check if weglot is needed and redirect to the right route
//        $request = $event->getRequest();
//        preg_match('/^\/[a-z]{2}\//', $request->getPathInfo(), $matches);
//        if (isset($matches[0])) {
//            $languageCode = str_replace('/', '', $matches[0]);
//            $request->getSession()->set('_locale', $languageCode);
//            $url = str_replace($matches[0], '/', $event->getRequest()->getRequestUri());
//            $response = new RedirectResponse($url);
//            $event->setResponse($response);
//        }
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        // try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->setLocale($locale);
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getLocale());
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
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