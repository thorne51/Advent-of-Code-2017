<?php
/**
 * Created by PhpStorm.
 * User: thorn
 * Date: 2018/03/19
 * Time: 02:59
 */

$input = file_get_contents('input.txt');
$input = "pbga (66)
xhth (57)
ebii (61)
havc (66)
ktlj (57)
fwft (72) -> ktlj, cntj, xhth
qoyq (66)
padx (45) -> pbga, havc, qoyq
tknk (41) -> ugml, padx, fwft
jptl (61)
ugml (68) -> gyxo, ebii, jptl
gyxo (61)
cntj (57)";

$top_programs = [];
$programs = [];
foreach (explode("\n", $input) as $program) {
    $parts = explode(' -> ', $program);
    $program_details = explode(' ', $parts[0]);
    $programs[$program_details[0]] = [
        'weight' => $program_details[1],
        'children' => isset($parts[1]) ? explode(', ', $parts[1]) : [],
    ];
}

function findParent($programs, $program) {
    foreach ($programs as $name => $details) {
        if (in_array($program, $details['children'])) {
            return $name;
        }
    }
    return false;
}

reset($programs);
$parent = key($programs);
$current_parent = '';
while ($parent !== false) {
    $current_parent = $parent;
    $parent = findParent($programs, $parent);
}

echo "{$current_parent} is at the bottom";