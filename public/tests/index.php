<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 26.05.2020
 * Time: 17:55
 */



require_once ('./simplehtmldom_2_0-RC2/simple_html_dom.php');



//print_r(readKotKeys());

$csv = readCsvToArray('Рабочий_лист_Ответы_Ответы_на_форму_1.csv');

//print_r(array_slice($csv[1], 101, 42)); exit;

foreach ($csv as $person)
{
    if( ! isset($result)) {
        $result[] = array_merge(
            array_slice($person, 0, 51),
            ['emi1', 'emi2', 'emi3', 'emi4', 'emi_total'],
            array_slice($person, 51, 50),
            ['KOT_Total'],
            array_slice($person, 101, 42),
            ['l_test_1', 'l_test_2', 'l_test_3', 'l_test_4', 'l_test_total']
        );
        continue;
    }

    $item = array_merge(
        array_slice($person, 0, 5),
        emInCalculate($person),
        KotCalculate($person),
        lTestCalculate($person)
    );

    $result[] = $item;
}

// save to file
$fp = fopen('file.csv', 'w+');
foreach ($result as $item)
{
    $item = array_map('strip_tags', $item);
    fputcsv($fp, $item);
}

// display table
echo '<style>table {border-collapse: collapse;} td {border: 1px solid #000; padding: 2px;}</style>';
echo '<table>';
foreach ($result as $item)
{
    echo '<tr>';

    foreach ($item as $v)
    {
        echo '<td>' . $v . '</td>';
    }

    echo '</tr>';
}
echo '</table>';

//print_r(array_slice($csvArr[3], 51, 50));
//emInCalculateTotal($csvArr[7]);

function lTestCalculate($person)
{
    $sets = [
        'l_test_1' => [2, 10, 18, 25, 31, 38],
        'l_test_2' => [4, 7, 8, 14, 16, 23, 27, 28, 32, 33, 35, 38],
        'l_test_3' => [1,3, 5, 6,12, 13,19, 22,26, 30, 36, 37],
        'l_test_4' => [9,11,15,17, 20,21, 24, 29, 34,40,41,42]
    ];

    $keys = [
        '1. Не характерно'          => 1,
        '2. Мало характерно'        => 2,
        '3. Довольно характерно'    => 3,
        '4. Характерно'             => 4
    ];

    $person = array_slice($person, 101, 42);

    foreach ($person as $key=>$val)
    {
        $result[$key] = 0;

        if(isset($keys[$val]))
        {
            $result[$key] = $keys[$val];
            @$result['l_test_total'] += $result[$key];

            foreach ($sets as $setKey=>$setVal)
            {
                if(in_array($key+1, $setVal))
                {
                    @$result[$setKey] += $result[$key];
                }
            }
        }
    }

    foreach ($result as $k=>$v)
    {
        if(isset($person[$k]))
        {
            $result[$k] = '<span style="background: lawngreen; padding: 3px;">' . $v . '</span> - ' . $person[$k];
        }
    }

    ksort($result, SORT_NATURAL);

    return $result;
}


function KotCalculate($person)
{
    $person = array_slice($person, 51, 50);
    $result = [];
    $keys = readKotKeys();

    $keys[4]  = 'Да';
    $keys[8]  = 'Sharp M.C.                             Sharp M.C.';
    $keys[11] = 'Ни сходное, ни противоположное';
    $keys[16] = 'Ни';
    $keys[19] = 'Ни сходное, ни противоположное';
    $keys[21] = '3. Трое докторов не лучше одного., 5. У семи нянек дитя без глаза.';
    $keys[47] = '4. Не все то золото, что блестит., 5. Не по виду суди, а по делам гляди';

    $total = 0;
    foreach ($person as $key=>$val)
    {
        $v = preg_match('#(\d+)\.#', $val, $match) ? $match[1] : $val;

        if($v == $keys[$key+1] OR $val == $keys[$key+1]) {
            $person[$key] = '<span style="background: lawngreen; padding: 3px;">v</span> - '. $val;
            $total += 1;
        }

    }

    $person['KOT_total'] = $total;

    return $person;
}

function emInCalculate($person)
{
    $sets = [
        'em_in_1' => [1, 2, 3, 5, 9, 11, 13, 15, 17, 20, 24, 27, 29, 30, 32, 34, 36, 38, 40, 42, 44, 46],
        'em_in_2' => [4, 6, 7, 8, 10, 12, 14, 18, 19, 21, 22, 23, 25, 26, 28, 31, 33, 35, 37, 39, 41, 43, 45],
        'em_in_3' => [1, 3, 7, 8, 11, 13, 14, 18, 20, 22, 26, 27, 29, 31, 32, 34, 35, 38, 41, 42, 45, 46],
        'em_in_4' => [2, 4, 5, 6, 9, 10, 12, 15, 16, 17, 19, 21, 23, 24, 25, 28, 30, 33, 36, 37, 39, 40, 43, 44]
    ];

    $result = [];
    $keys = readEmInKeys();
    $person = array_slice($person, 5, 46);

    foreach ($person as $key=>$val)
    {
        $result[$key] = 0;

        if(isset($keys[$key][$val]))
        {
            $result[$key] = $keys[$key][$val];
            @$result['em_in_total'] += $result[$key];

            foreach ($sets as $setKey=>$setVal)
            {
                if(in_array($key+1, $setVal))
                {
                    @$result[$setKey] += $result[$key];
                }
            }
        }
    }

    foreach ($result as $k=>$v)
    {
        if(isset($person[$k]))
        {
            $result[$k] = '<span style="background: lawngreen; padding: 3px;">' . $v . '</span> - ' . $person[$k];
        }
    }

    ksort($result, SORT_NATURAL);

    return $result;

}
function readEmInKeys()
{
    static $answers = [];

    if( ! empty($answers))
    {
        return $answers;
    }

    $html = file_get_html('em_in_keys.html');

    foreach ($html->find('tr') as $tr)
    {
        if (!isset($headGrabbed))
        {
            $headGrabbed = true;
            continue;
        }

        $answers[] = [
            'Совсем не согласен' => (int)$tr->find('td', 2)->find('p', 0)->innertext,
            'Скорее не согласен' => (int)$tr->find('td', 3)->find('p', 0)->innertext,
            'Скорее согласен' => (int)$tr->find('td', 4)->find('p', 0)->innertext,
            'Полностью согласен' => (int)$tr->find('td', 5)->find('p', 0)->innertext,
        ];

    }

    return $answers;
}

function readKotKeys()
{
    static $answers = [];

    if( ! empty($answers))
    {
        return $answers;
    }

    $html = file_get_html('kot_keys.html');

    foreach ($html->find('tr') as $tr)
    {
        $k1 = (int) $tr->find('td', 0)->find('span', 0)->innertext;
        $v1 = $tr->find('td', 1)->find('span', 0)->innertext;
        $answers[$k1] = $v1;

        $k2 = (int) $tr->find('td', 2)->find('span', 0)->innertext;
        $v2 = $tr->find('td', 3)->find('span', 0)->innertext;
        $answers[$k2] = $v2;
    }

    ksort($answers);

    return $answers;
}

function readCsvToArray($filename)
{
    $csv = array();
    $lines = file($filename, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $key => $value)
    {
        $csv[$key] = str_getcsv($value);
    }

    return $csv;
}
