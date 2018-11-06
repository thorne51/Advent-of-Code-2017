<?php
$fh = fopen('input.txt', 'r');
$diffs = [];
while ($row = fgetcsv($fh, 0, "\t")) {
    $max = max($row);
    $min = min($row);
    $diffs[] = $max - $min;
}

echo "Checksum is: " . array_sum($diffs) . "\r\n";