<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 2018-03-19
 * Time: 09:27 AM
 */

$input = file_get_contents('input.txt');
//$input = "b inc 5 if a > 1
//a inc 1 if b < 5
//c dec -10 if a >= 1
//c inc -20 if c == 10";

$instructions = explode("\n", $input);
$registers = [];
foreach ($instructions as $instruction) {
    // skip blanks
    if (trim($instruction) == '') {
        continue;
    }
    $parts = explode(' if ', $instruction);

    // check the condition
    $condition_parts = explode(' ', $parts[1]);
    $condition = false;
    $value = intval($condition_parts[2]);
    // check if register initialised
    if (!isset($registers[$condition_parts[0]])) {
        $registers[$condition_parts[0]] = 0;
    }
    $register_value = $registers[$condition_parts[0]];
    switch ($condition_parts[1]) {
        case '==':
            $condition = $register_value == $value;
            break;
        case '!=':
            $condition = $register_value != $value;
            break;
        case '>':
            $condition = $register_value > $value;
            break;
        case '>=':
            $condition = $register_value >= $value;
            break;
        case '<':
            $condition = $register_value < $value;
            break;
        case '<=':
            $condition = $register_value <= $value;
            break;
        default:
            throw new Exception('Unsupported boolean operator: ' . $condition_parts[1]);
            break;
    }

    if ($condition) {
        $operation_parts = explode(' ', $parts[0]);
        // check that register is initialized
        if (!isset($registers[$operation_parts[0]])) {
            $registers[$operation_parts[0]] = 0;
        }
        $value = intval($operation_parts[2]);
        switch ($operation_parts[1]) {
            case 'inc':
                $registers[$operation_parts[0]] += $value;
                break;
            case 'dec':
                $registers[$operation_parts[0]] -= $value;
                break;
            default:
                throw new Exception('Unsupported operator: ' . $operation_parts[1]);
                break;
        }
    }
}

var_dump($registers);
echo max($registers) . ' is the biggest register value';
