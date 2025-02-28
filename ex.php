<?php
$x = 1;
$c = 4;
$f = 10;
$weat = 13;

// Calculate absolute differences
$diff_x = abs($weat - $x);
$diff_c = abs($weat - $c);
$diff_f = abs($weat - $f);

// Find the smallest difference
$smallest = min($diff_x, $diff_c, $diff_f);

// Determine which number has the smallest difference
if ($smallest == $diff_x) {
    $closest = $x;
} elseif ($smallest == $diff_c) {
    $closest = $c;
} else {
    $closest = $f;
}

// Output the closest number
echo "The number closest to $weat is: $closest";
?>
