<?php
//phpinfo();

$current_date = null;

if (!empty($current_date) && mktime(0, 0, 0, date("m"), date("d"), date("Y")) != $current_date) {
    $time = $current_date + 18 * 3600;
}

if (date("N") > 5) { // saturday or sunday - take 6 p.m. friday
    $d = date('N') - 5;
    $time = mktime(18, date("i"), date("s"), date("m"), date("d") - $d, date("Y"));
} elseif (date("H") > 17) { // after 6.p.m take 6 p.m.
    $time = mktime(18, date("i"), date("s"), date("m"), date("d"), date("Y"));
} elseif (date("H") < 8) { // before 8 a.m. take 6 p.m.
    $d = date('N') == 1 ? 3 : 1; // check is monday
    $time = mktime(18, date("i"), date("s"), date("m"), date("d") - $d, date("Y"));
} else {
    $time = time();
}


$result = [];

$provider = [
    ['-31abc', 0],
    [['field' => 123], 'field'],
    [0, 0],
    [1, 0],
    [29, 0],
    [30, 1],
    [-30, 0],
    [2700, 89],
    ['', 0],
    ["", 0],
    [null, 0],
    [false, 0],
    ['0', 0],
    [[], 0],
    ['-1', 0],
    ['abc', 0],
];

foreach ($provider as $data) {
    $serializeData = serialize($data[0]);
    $result[] = [$serializeData, $data[1], $data[2]];
}

foreach ($result as $text) {
    $arr = unserialize((string)$text[0]);
    $test[] = !empty($arr['0']);
}


$test = array_merge($provider, $result);
$cc = 1;