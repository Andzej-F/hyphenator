
<?php

// $wordsArray = file('https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt');

// $array = [
//     0 => "a2n",
//     1 => ".mis1",
//     2 => "m2is",
//     3 => "2n1s2",
//     4 => "n2sl",
//     5 => "s1l2",
//     6 => "s3lat",
//     7 => "st4r",
//     8 => "4te.",
//     9 => "1tra",
// ];

$start_array = [0 => ".mis1"];
$end_array = [0 => "4te."];
$middle_array = [
    0 => "a2n",
    1 => "m2is",
    2 => "2n1s2",
    3 => "n2sl",
    4 => "s1l2",
    5 => "s3lat",
    6 => "st4r",
    7 => "1tra"
];

$input = "mistranslate";

echo hyphenate('mistranslate', [0 => '.mis1']);

function hyphenate($input, $array)
{
    foreach ($array as $phrase) {

        $input_ast = addAsterisk($input);
        echo $input_ast . '<br>';
        $phrase_ast = addAsterisk($phrase);
        echo $phrase_ast . '<br>';

        //Check if phrase matches the input
        if (str_contains($input_ast, $phrase_ast)) {
            // Check if  begins with dot
            if (str_starts_with($phrase, '.')) {

                // Check if the input begins with the given phrase
                if (str_starts_with($input_ast, $phrase_ast)) {

                    $start_pos = strpos($input_ast, $phrase_ast);
                    echo $start_pos;

                    // Get the positions of numbers in phrase
                    $nbr_array = numberPosition($phrase);

                    // mis1
                    // 0123
                    // m*i*s*
                    // 012345
                    foreach ($nbr_array as $position => $value) {
                        $pos = $start_pos + $position;

                        // Chek if the given input position already has a number
                        if (ctype_digit($input_ast[$pos])) {

                            // Chek if it is bigger than the number in a phrase
                            echo "<br>kuku " . $input_ast[$pos];
                            $max_value = max($input_ast[$pos], $value);

                            $input_ast = substr_replace($input_ast, $max_value, $pos, 1);
                        }
                        if ($input_ast[$pos] === '*') {
                            echo "<br>kuku " . $input_ast[$pos];
                            echo "<br>kuku " . $value;
                            echo "<br>kuku " . $pos;
                            $input_ast = substr_replace($input_ast, $value, $pos, 1);
                        }
                    }
                }
            }
        } else {
            echo "No match found<br>";
        }
    }
    echo '<pre>';
    print_r(get_defined_vars());
    echo '</pre>';
    return $input_ast;
}
/*
        //            "2n1s2"
        //            "*n*s*"
        //  m*i*s*t*r*a*n*s*l*a*t*e

        //        "s1l2"
        //  mistrans1l2ate

        //        "s3lat"
        //  mistrans3l2ate

        // add asterisks
        // mis1translate => m*i*s1t*r*a*n*s*l*a*t*e

        //1 check if the phrase begins with dot
        // str_ends_with($string $haystack, string $needle):bool;

        // 2 check if the phrase ends with dot
        // if yes, remove the dot from phrases end
        // check if it matches 
        // if yes, check if it contains any numbers
        // add the phrase to the input's end

        // 3 for the rest phrases
        // check if it matches 
        // if yes, check if it contains any numbers
        // add the phrase to the input's end

        // Remove the numbers from the phrases
        // debug: $phrase = ".mis1";
        $phrase_trim = preg_replace('/[\d]/', '', $phrase);
        // debug: $phrase_trim='.mis';

        // Remove the numbers and asterisks from the input
        // debug: $input = 'mistranslate';
        $input_trim = preg_replace('/[\d,\*]/', '', $input);
        // debug: $input_trim='mistranslate';

        if (preg_match("/$phrase_trim/", $input_trim)) {

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

            $phrase = addAsterisk($phrase);

            // Additionally for phrase change the numbers into asterisks, for matching purposes
            $phrase = preg_replace('/\d/', '*', $phrase); // 2n1s2 \*n\*s\*

            $input = addAsterisk($input);
            // echo "line " . __LINE__ . " input " . $input . '<br>';

            $start_pos = strpos($input, $phrase);

            if ($start_pos !== false) {

                foreach ($positions as $position => $value) {

                    $pos = $start_pos + $position;

                    // echo "line " . __LINE__ . " input[pos]" . $input[$pos] . '<br>';
                    // Chek if the given input position already has a number
                    if (ctype_digit($input[$pos])) {
                        // echo substr_replace('m*i*s*t', '5', 3, 1);// m*i5s*t

                        // echo "line " . __LINE__ . " input[pos]" . $input[$pos] . '<br>';
                        // Chek if it is bigger than the number in a phrase
                        $input[$pos] = max($input[$pos], $value);
                        $input = substr_replace($input, $value, $pos, 1); // m*i5s*t
                        // echo "line " . __LINE__ . " input " . $input . '<br>';
                    }
                    if ($input[$pos] === '*') {
                        // echo "line " . __LINE__ . " input[pos]" . $input[$pos] . '<br>';
                        // $input[$pos] = $value;
                        // echo "<hr>line " . __LINE__ . " input " . $input . '<br>';
                        // echo "line " . __LINE__ . " pos " . $pos . '<br>';
                        // echo "line " . __LINE__ . " value " . $value . '<br>';
                        $input = substr_replace($input, $value, $pos, 1); // m*i5s*t

                        // echo "line " . __LINE__ . " input" . $input . '<br>';
                    }
                }
            }
        }
    }
    // echo "<pre>";
    // print_r(get_defined_vars());
    // echo "</pre>";
    return $input;
}
*/

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
 * Function adds asterisks between two adjacent letters 
 * */
function addAsterisk($word)
{
    // Convert input string to array
    $array = str_split($word, 1);

    // Add asterisks between two adjacent letters in input
    for ($i = 0; $i < (count($array) - 1); $i += 1) {
        if (ctype_alpha($array[$i]) && ctype_alpha($array[$i + 1])) {
            $array[$i] .= '*';
        }
    }

    $word = implode('', $array);

    if (preg_match('/[\d,\.]/', $word)) {

        // return preg_replace('/[\d,\.]/', '*', $word);
        return $word;
    }

    return "*$word*";
}
// substr_replace(
//     array|string $string,
//     array|string $replace,
//     array|int $offset,
//     array|int|null $length = null
// ): string|array

// echo '<br><br>';
// echo substr_replace('m*i*s*t', '5', 3, 1);// m*i5s*t
// $input = '.m*i*s*t*r*a*n*s*l*a*t*e.';
// $pos = 12;
// $value = 2;
// $input = substr_replace($input, $value, $pos, 1); // m*i5s*t
// echo '<br>****************************************************************<br>';
// echo $input;
// echo max(7, "3"); // 7

//str_starts_with(string $haystack, string $needle): bool
// if (str_starts_with('abc', 'ab')) {
//     echo "True, there is a match<br>";
// } else {
//     echo "No match found<br>";
// }
// $middle_array = [
//     0 => "a2n",
//     1 => "m2is",
//     2 => "2n1s2",
//     3 => "n2sl",
//     4 => "s1l2",
//     5 => "s3lat",
//     6 => "st4r",
//     7 => "1tra"
// ];

// foreach ($middle_array as $phrase) {
//     echo $phrase . '<br>';
// }
