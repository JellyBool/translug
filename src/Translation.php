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
    protected $http;

    /**
     * Translation constructor.
     *
     * @param $http
     */
    public function __construct(Client $http)
    {
        $this->http = $http;
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
        if($this->isEnglish($text)) {
            return str_slug($text);
        }
        return str_slug($this->getTranslatedText($text));
    }

    /**
     * @param $text
     * @return mixed
     */
    private function getTranslatedText($text)
    {
        $url = $this->getTranslateUrl($text);
        $response =  $this->http->get($url);

        return  $this->checkTranlation(collect(\GuzzleHttp\json_decode($response->getBody(),true)));
    }

    /**
     * @param $collection
     * @return mixed
     */
    private function checkTranlation($collection)
    {
        if ($collection->get('errorCode') === 0 ) {
            return $this->getTranslatedTextFromCollection($collection);
        }

        throw new TranslationErrorException('Translate error, error_code : '.$collection->get('errorCode'));
    }

    /**
     * @param $collection
     * @return mixed
     */
    private function getTranslatedTextFromCollection($collection)
    {
        $translations = $collection->get('translation');

        return $translations[0];
    }

    /**
     * @param $text
     * @return string
     */
    private function getTranslateUrl($text)
    {
        return 'http://fanyi.youdao.com/openapi.do?keyfrom=laravist&key='.env('YOUDAO_API_KEY').'&type=data&doctype=json&version=1.1&q='.$text;
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

}