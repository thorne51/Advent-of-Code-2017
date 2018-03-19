<?php
/**
 * Created by PhpStorm.
 * User: thorn
 * Date: 2018/03/19
 * Time: 02:06
 */

$input = file_get_contents('input.txt');

$banks = array_map(function($item) {
    return intval($item);
}, explode("\t", $input));
//$banks = [0,2,7,0];

$cycles = 0;
$states = [implode('', $banks)];
$seen = false;

while (true) {
    $cycles++;

    $largest = max($banks);
    $largest_index = array_search($largest, $banks);

    $banks[$largest_index] = 0;
    $next_index = $largest_index + 1;
    if ($next_index >= count($banks)) {
        $next_index = 0;
    }
    while ($largest > 0) {
        $banks[$next_index]++;
        $largest--;

        $next_index++;
        if ($next_index >= count($banks)) {
            $next_index = 0;
        }
    }

    $state = implode('', $banks);
    if (in_array($state, $states)) {
        echo "Seen after {$cycles} cycles\n";

        if (!$seen) {
            $seen = true;
            $cycles = 0;
            $states = [$state];
        }
        else {
            break;
        }
    }
    $states[] = $state;
}