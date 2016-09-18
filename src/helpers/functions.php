<?php

if (!function_exists('translug')) {

    /**
     * Post title to translug.
     *
     * @param string|null $title.
     *
     * @return
     */
    function translug($title = '')
    {
        $translator = app('translug');

        if (!is_null($title)) {
            return $translator->translug($title);
        }

        return $translator;
    }
}
