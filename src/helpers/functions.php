<?php

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
