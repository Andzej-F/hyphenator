<?php

/**
 * Retrieving values
 * 
 * PHP version 8.0.7
 */

/**
 * Get matching phrases from the file
 * 
 * @param string $input_org Input string
 * 
 * @return array On success return array with matching phrases,
 * on failure return the file contents as an array
 */

function getMatch($input_org)
{
    $array = file('https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt', FILE_IGNORE_NEW_LINES);
    $matches = [];

    $input = ".$input_org."; // .mistranslate

    foreach ($array as $key => $phrase) {
        $phrase_format = preg_replace('/\d/', '', $phrase);

        if (str_starts_with($phrase_format, '.')) {
            $regex = "/^$phrase_format/";

            if (str_starts_with($input, $regex)) { // $input = .mistranslate.;  $regex= '/^.mis/'
                $matches[$key] = $phrase;
            }
        } elseif (str_ends_with($phrase_format, '.')) {
            $regex = "/$phrase_format$/";

            if (str_ends_with($input, $regex)) {
                $matches[$key] = $phrase;
            }
        } else {
            $regex = "/$phrase_format/";
        }

        if (preg_match($regex, $input)) {
            $matches[$key] = $phrase;
        }
    }

    return !empty($matches) ? $matches : $array;
}
