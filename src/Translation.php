<?php

namespace JellyBool\Translug;

use GuzzleHttp\Client;
use JellyBool\Translug\Exceptions\TranslationErrorException;

/**
 * Class Translation
 *
 * @package JellyBool\Translug
 */
class Translation
{

    /**
     * Youdao api url
     *
     * @var string
     */
    protected $api = 'http://fanyi.youdao.com/openapi.do?type=data&doctype=json&version=1.1&';
    /**
     * @var Client
     */
    protected $http;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * Translation constructor.
     *
     * @param Client $http
     * @param array $config
     */
    public function __construct(Client $http, array $config = [])
    {
        $this->http = $http;
        $this->config = $config;
    }

    /**
     * @param $text
     * @return mixed
     */
    public function translate($text)
    {
        return $this->getTranslatedText($text);
    }

    /**
     * @param $text
     * @return string
     */
    public function translug($text)
    {
        return str_slug($this->getTranslatedText($text));
    }

    /**
     * @param $text
     * @return mixed
     */
    private function getTranslatedText($text)
    {
        if ($this->isEnglish($text)) {
            return $text;
        }
        $text = $this->removeSegment($text);
        $url = $this->getTranslateUrl($text);
        $response = $this->http->get($url);

        return $this->getTranslation(json_decode($response->getBody(), true));
    }

    /**
     * @param array $translateResponse
     * @return mixed
     */
    private function getTranslation(array $translateResponse)
    {
        if ($translateResponse['errorCode'] === 0) {
            return $this->getTranslatedTextFromResponse($translateResponse);
        }

        throw new TranslationErrorException('Translate error, error_code : ' . $translateResponse['errorCode'] . '. Refer url: http://fanyi.youdao.com/openapi?path=data-mode');
    }

    /**
     * @param array $translateResponse
     * @return mixed
     */
    private function getTranslatedTextFromResponse(array $translateResponse)
    {
        return $translateResponse['translation'][0];
    }

    /**
     * @param $text
     * @return string
     */
    private function getTranslateUrl($text)
    {
        if (count($this->config) > 1) {
            $query = http_build_query($this->config);
            return $this->api . $query . '&q=' . $text;
        }
        return $this->api . 'keyfrom=' . config('services.youdao.from') . '&key=' . config('services.youdao.key') . '&q=' . $text;
    }

    /**
     * @param $text
     * @return bool
     */
    private function isEnglish($text)
    {
        if (preg_match("/\p{Han}+/u", $text)) {
            return false;
        }

        return true;
    }

    /**
     * Remove segment #
     *
     * @param $text
     * @return mixed
     */
    private function removeSegment($text)
    {
        return str_replace('#', '', ltrim($text));
    }

}