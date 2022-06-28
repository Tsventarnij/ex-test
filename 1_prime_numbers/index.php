<?php
foreach (range(1, 100) as $number) {
    if ($number == 1) {
        echo "$number \n";
        continue;
    }
    $multiples = [];
    $prevNumber = $number - 1;
    for($i = 2; $i < $prevNumber; $i++) {
        if ($number % $i == 0) {
            $multiples[] = $i;
        }
    }

    $result =  empty($multiples) ? 'PRIME' : implode(',', $multiples);
    echo "$number [$result]\n";
}
