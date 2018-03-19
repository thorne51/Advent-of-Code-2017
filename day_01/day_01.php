<?php
/**
 * Created by PhpStorm.
 * User: thorn
 * Date: 2018/03/18
 * Time: 20:00
 */

$input = file_get_contents('input.txt');

/***** part 1 *****/
$previous_character = $input[strlen($input) - 1];
$running_total = 0;
for ($i = 0; $i < strlen($input); $i++) {
    if ($input[$i] == $previous_character) {
        $running_total += intval($previous_character);
    }
    $previous_character = $input[$i];
}
echo "Answer part 1: {$running_total}\n";


/***** part 2 *****/
$running_total = 0;
$steps_forward = round(strlen($input) / 2); // i know they said its even, just in case we test with uneven string
$steps_forward = intval($steps_forward); // when rounding, result is a float value, which causes notice error when used as index on string.
for ($i = 0; $i < strlen($input); $i++) {
    // get index of character to compare
    $index = $i + $steps_forward;

    // if index out of bounds, subtract length of $input
    if ($index >= strlen($input)) {
        $index -= strlen($input);
    }

    // increment our running total if comparison matches
    if ($input[$i] == $input[$index]) {
        $running_total += intval($input[$i]);
    }
}
echo "Answer part 2: {$running_total}\n";