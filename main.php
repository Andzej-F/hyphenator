
<?php

echo hyphenate('mistranslate') . '<br>';
echo hyphenate('vigorous') . '<br>';
echo hyphenate('changed') . '<br>';
echo hyphenate('pitch') . '<br>';
echo hyphenate('uncopyrightable') . '<br>';
echo hyphenate('system') . '<br>';
echo hyphenate('disastrous') . '<br>';
echo hyphenate('frightening') . '<br>';
echo hyphenate('encouraging') . '<br>';

function hyphenate($input)
{
    $array = getMatch($input);

    $symbol = '*';

    $input_format = "." . addSymbol($input, $symbol) . "."; // .m*i*s*t*r*a*n*s*l*a*t*e.

    foreach ($array as $phrase) {

        $phrase_ast = addSymbol($phrase, $symbol); // .m*i*s1        

        $phrase_regex = preg_replace('/[\d,\*]/', '[\*,\d]', $phrase_ast); // /[\*,\d]n[\*,\d]s[\*,\d]/

        if (preg_match("/$phrase_regex/", $input_format, $output_array)) {

            $start_pos = strpos($input_format, $output_array[0]); // 0

            // Get the positions of numbers in the phrase
            $nbr_array = numberPosition($phrase_ast); // [6 => 1]

            foreach ($nbr_array as $position => $value) {
                $pos = $start_pos + $position; // 6

                // Chek if the given input position already has a number
                if (ctype_digit($input_format[$pos])) {

                    // Chek if it is bigger than the number in a phrase
                    $max_value = max($input_format[$pos], $value);

                    $input_format = substr_replace($input_format, $max_value, $pos, 1);
                }
                if ($input_format[$pos] === '*') {

                    $input_format = substr_replace($input_format, $value, $pos, 1);
                }
            }
        }
    }

    // remove dots, asterisks, even numbers
    $input_format = preg_replace('/[\.,\*,2,4,6,8,0]/', '', $input_format);

    // Replace odd numbers with hyphens
    $input_format = preg_replace('/[1,3,5,7,9]/', '-', $input_format);

    return $input_format;
}

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

/**
 * Function finds positions of numbers in a string
 * 
 * @param string $phrase
 * 
 * @return array Array containing matching values
 */

function numberPosition(string $phrase): array
{
    // Positions of numbers in a phrase $position => $value
    $positions = [];

    // Split given phrase into an array
    $phrase_array = str_split($phrase, 1);

    foreach ($phrase_array as $position => $value) {
        if (is_numeric($value)) {
            // Save matched number positions in the array
            $positions += [$position => $value]; // 0=>2, 1=>2, 2=>4
        }
        // print_r(get_defined_vars());
    }
    return $positions;
}

/**
 * Function adds symbols between two adjacent letters 
 * 
 * @param string $word Input word
 * @param string $aymbol Input word
 * 
 * @return string
 * */
function addSymbol($word, $symbol)
{
    // Convert input string to array
    $array = str_split($word, 1);

    // Add asterisks between two adjacent letters in input
    for ($i = 0; $i < (count($array) - 1); $i += 1) {
        if (ctype_alpha($array[$i]) && ctype_alpha($array[$i + 1])) {
            $array[$i] .= $symbol;
        }
    }

    return implode('', $array);
}
