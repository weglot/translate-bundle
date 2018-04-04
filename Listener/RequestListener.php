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
    private $destinationLanguages;


    /**
     * RequestListener constructor.
     * @param Parser $parser
     * @var $destinationLanguages
     */
    public function __construct(Parser $parser, $destinationLanguages)
    {
        $this->parser = $parser;
        $this->destinationLanguages = $destinationLanguages;
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
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->getRequest()->isXmlHttpRequest()) {
            $request = $event->getRequest();
            $languageFrom = $request->getDefaultLocale();
            $languageTo = $request->getLocale();
            if ($languageFrom != $languageTo && in_array($languageTo,$this->destinationLanguages)) {
                $content = $event->getResponse()->getContent();
                $translatedContent = $this->parser->translateDomFromTo($content, $languageFrom, $languageTo);
                $event->getResponse()->setContent($translatedContent);
            }
        }
    }
}