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
use Weglot\Parser\Parser;

class RequestListener implements EventSubscriberInterface
{
    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @var array
     */
    protected $destinationLanguages;

    protected $bannedRoutes = [
        '/_profiler/open',
        '/_profiler/{token}'
    ];

    /**
     * RequestListener constructor.
     * @param Parser $parser
     * @var $destinationLanguages
     */
    public function __construct(Parser $parser, array $destinationLanguages)
    {
        $this->parser = $parser;
        $this->destinationLanguages = $destinationLanguages;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 17],
            KernelEvents::RESPONSE => ['onKernelResponse'],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->getRequest()->isXmlHttpRequest()) {
            $request = $event->getRequest();
            $response = $event->getResponse();

            $languageFrom = $request->getDefaultLocale();
            $languageTo = $request->getLocale();

            $router_path_check = ($request->request->has('_weglot_router_path') &&
                !in_array($request->request->get('_weglot_router_path'), $this->bannedRoutes));

            if ($router_path_check &&
                $languageFrom != $languageTo && in_array($languageTo, $this->destinationLanguages)) {
                $content = $response->getContent();
                $translatedContent = $this->parser->translate($content, $languageFrom, $languageTo);
                $response->setContent($translatedContent);
            }
        }
    }
}
