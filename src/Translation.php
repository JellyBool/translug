<?php

namespace JellyBool\Translug;

use GuzzleHttp\Client;
use JellyBool\Translug\Exceptions\TranslationErrorException;

/**
 * Class Translation.
 */
class Translation
{
    /**
     * Youdao new API url.
     *
     * @var string
     */
    protected $api = 'https://openapi.youdao.com/api?from=zh-CHS&to=EN&';
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
     * @param array  $config
     */
    public function __construct(Client $http, array $config = [])
    {
        $this->http = $http;
        $this->config = $config;
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    public function translate($text)
    {
        return $this->getTranslatedText($text);
    }

    /**
     * @param $text
     *
     * @return string
     */
    public function translug($text)
    {
        return str_slug($this->getTranslatedText($text));
    }

    /**
     * @param $text
     *
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
     *
     * @return mixed
     */
    private function getTranslation(array $translateResponse)
    {
        if ((int) $translateResponse['errorCode'] === 0) {
            return $this->getTranslatedTextFromResponse($translateResponse);
        }
        throw new TranslationErrorException('Translate error, error_code : '.$translateResponse['errorCode'].'. Refer url: http://ai.youdao.com/docs/api.s');
    }

    /**
     * @param array $translateResponse
     *
     * @return mixed
     */
    private function getTranslatedTextFromResponse(array $translateResponse)
    {
        return $translateResponse['translation'][0];
    }

    /**
     * @param $text
     *
     * @return string
     */
    private function getTranslateUrl($text)
    {
        $salt = md5(time());
        $query = [
            'sign'   => md5($this->config['appKey'].$text.$salt.$this->config['appSecret']),
            'appKey' => $this->config['appKey'],
            'salt'   => $salt,
        ];

        return $this->api.http_build_query($query).'&q='.urlencode($text);
    }

    /**
     * @param $text
     *
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
     * Remove segment #.
     *
     * @param $text
     *
     * @return mixed
     */
    private function removeSegment($text)
    {
        return str_replace('#', '', ltrim($text));
    }
}
