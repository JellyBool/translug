<?php

use Illuminate\Support\Str;

if (!function_exists('translug')) {

    /**
     * Text to translug.
     *
     * @param string|null $text.
     *
     * @return
     */
    function translug($text = '')
    {
        $translator = app('translug');

        if (!is_null($text)) {
            return $translator->translug($text);
        }

        return $translator;
    }
}

if (!function_exists('str_slug')) {

    /**
     * Text to translug.
     *
     * @param string|null $text.
     *
     * @return
     */
    function str_slug($text = '')
    {
        return Str::slug($text);
    }
}
