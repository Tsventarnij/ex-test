<?php

    $array = [];
    for ($i=ord(','); $i <= ord('|'); $i++) {
        $array[] = chr($i);
    }

    shuffle($array);
    unset($array[array_rand($array)]);

    $numArray = array_flip(range(ord(','), ord('|')));

    foreach ($array as $char) {
        if (isset($numArray[ord($char)])) {
            unset($numArray[ord($char)]);
        }
    }

    echo 'Missing character - ' . implode(',', array_map('chr', $numArray));