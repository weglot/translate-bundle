<?php
/**
 * @author Floran Pagliai
 * Date: 13/11/2017
 * Time: 15:29
 */

namespace Weglot\TranslateBundle\Services;

use Unirest;

class Client
{
    const BASE_URL = 'https://api.weglot.com';
    const ENDPOINT_TRANSLATE = '/translate';

    /** @var string $apiKey */
    private $apiKey;

    /**
     * Client constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function handle($endpoint, $body = array())
    {
        $queryUrl = self::BASE_URL . $endpoint;
        $queryUrl .= '?api_key=' . $this->apiKey;

        $body = Unirest\Request\Body::Json($body);
        $headers = array(
            'Content-Type' => 'application/json',
        );
        $response = Unirest\Request::post($queryUrl, $headers, $body);

        if (($response->code < 200) || ($response->code > 206)) {
            throw new \Exception($response->body, $response->code);
        }

        return json_decode(json_encode($response->body), true);
    }

    public function translate($languageFrom, $languageTo, $bot, $pageTitle, $requestUrl, $words)
    {
        $body = array(
            'l_from' => $languageFrom,
            'l_to' => $languageTo,
            'bot' => $bot,
            'title' => $pageTitle,
            'request_url' => $requestUrl,
            'words' => $words
        );

        return $this->handle(self::ENDPOINT_TRANSLATE, $body);
    }
}