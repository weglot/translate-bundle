<?php

namespace Weglot\TranslateBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Weglot\Client\Api\Exception\ApiError;
use Weglot\Client\Api\Exception\InputAndOutputCountMatchException;
use Weglot\Client\Api\Exception\InvalidWordTypeException;
use Weglot\Client\Api\Exception\MissingRequiredParamException;
use Weglot\Client\Api\Exception\MissingWordsOutputException;
use Weglot\Parser\Parser;
use Psr\Cache\InvalidArgumentException;
use Weglot\TranslateBundle\WeglotTranslateBundle;

/**
 * Class RequestListener
 * @package Weglot\TranslateBundle\Listener
 */
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

        // setting HttpClient user-agent
        $this->parser->getClient()->setHttpClient(null, 'Symfony\\' . WeglotTranslateBundle::VERSION);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse'],
        ];
    }

    /**
     * @param FilterResponseEvent $event
     * @throws InvalidArgumentException
     * @throws ApiError
     * @throws InputAndOutputCountMatchException
     * @throws InvalidWordTypeException
     * @throws MissingRequiredParamException
     * @throws MissingWordsOutputException
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->getRequest()->isXmlHttpRequest()) {
            $request = $event->getRequest();

            if ($this->needsTranslation($event)) {
                $response = $event->getResponse();

                $translatedContent = $this->parser->translate($response->getContent(), $request->getDefaultLocale(), $request->getLocale());
                $response->setContent($translatedContent);
            }
        }
    }

    /**
     * @param FilterResponseEvent $event
     * @return bool
     */
    protected function needsTranslation(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        $languageFrom = $request->getDefaultLocale();
        $languageTo = $request->getLocale();

        $routerPathCheck = ($request->request->has('_weglot_router_path') &&
                                !in_array($request->request->get('_weglot_router_path'), $this->bannedRoutes));
        $isLanguageOk = ($languageFrom != $languageTo && in_array($languageTo, $this->destinationLanguages));

        return $routerPathCheck && $isLanguageOk;
    }
}
