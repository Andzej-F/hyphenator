<?php

require 'retrieve_data.php';

/**
 * Hyphenation algorithm
 * 
 * PHP version 8.0.7
 */

/**
 * Hyphenation function
 * 
 * @param string $input Input word
 * 
 * @return string return hyphenated word
 */
function hyphenate($input)
{
    // Get the array of matching values
    $array = getMatch($input);

    // Remove empty spaces from input
    $input = trim($input);

    // Example value "*"
    $symbol = '*';

    // Add dots at the beginning and end of the input
    // Include asterisks between input letters
    $input_format = "." . addSymbol($input, $symbol) . "."; // .m*i*s*t*r*a*n*s*l*a*t*e.

    foreach ($array as $phrase) {

        $phrase_ast = addSymbol($phrase, $symbol); // .m*i*s1        

        $phrase_regex = preg_replace('/[\d,\*]/', '[\*,\d]', $phrase_ast); // /.m[\*,\d]i[\*,\d]s[\*,\d]/

        if (preg_match("/$phrase_regex/", $input_format, $output_array)) {

            // Get the starting position of the matching phrase
            $start_pos = strpos($input_format, $output_array[0]); // 0

            // Get the positions of number(s) in the phrase
            $nbr_array = numberPosition($phrase_ast); // [6 => 1]

            foreach ($nbr_array as $position => $value) {
                // Number's position relative to the input
                $pos = $start_pos + $position; // 6

                // Chek if the given input position already has a number
                if (ctype_digit($input_format[$pos])) {

                    // Select bigger number
                    $max_value = max($input_format[$pos], $value);

                    // Include the number in the input
                    $input_format = substr_replace($input_format, $max_value, $pos, 1);
                }
                if ($input_format[$pos] === $symbol) {

                    $input_format = substr_replace($input_format, $value, $pos, 1);
                }
            }
        }
    }

    // Remove dots, asterisks, even numbers
    $input_format = preg_replace('/[\.,\*,2,4,6,8,0]/', '', $input_format);

    // Replace odd numbers with hyphens
    $input_format = preg_replace('/[1,3,5,7,9]/', '-', $input_format);

    return $input_format;
}

/**
 * Find positions of numbers in a phrase
 * 
 * @param string $phrase
 * 
 * @return array Array containing matching values in format "position"=>"value"
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
    }
    return $positions;
}

/**
 * Function adds custom symbols between two adjacent letters 
 * 
 * @param string $word Input value
 * @param string $symbol Chosen symbol (e.g. "*"," ", "_")
 * 
 * @return string
 * */
function addSymbol($word, $symbol)
{
    // Convert input string to array
    $array = str_split($word, 1);

    // Add symbols between two adjacent letters in input
    for ($i = 0; $i < (count($array) - 1); $i += 1) {
        if (ctype_alpha($array[$i]) && ctype_alpha($array[$i + 1])) {

            // Insert symbol after the letter
            $array[$i] .= $symbol;
        }
    }

    return implode('', $array);
}
