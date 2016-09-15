<?php

if (! function_exists('translug')) {

    /**
     * Arrange for a flash message.
     *
     * @param  string|null $message
     * @return
     */
    function translug($title = '')
    {
        $translator = app('translug');

        if (! is_null($title)) {
            return $translator->translug($title);
        }

        return $translator;
    }
}
