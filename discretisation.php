<?php

function query($SQL)
{
    $db = pg_connect("host=localhost port=5432 dbname=master_siglis user=etudiant password=Q7lK68hmfMLHvnE");

    $result = pg_query($db, $SQL);

    if (!$result) {
        echo "Une erreur est survenue.\n";
        exit;
    }

    return pg_fetch_all($result);
}

function percentile($array, $percentile)
{
    sort($array);
    $index = ($percentile / 100) * count($array);
    if (floor($index) == $index) {
        $result = ($array[$index - 1] + $array[$index]) / 2;
    } else {
        $result = $array[floor($index)];
    }
    return $result;
}

function quantile($data)
{
    return [
        'legende' => [
            percentile($data, 100),
            percentile($data, 75),
            percentile($data, 50),
            percentile($data, 25),
            percentile($data, 0),
        ],
        'colors' => ['#800026', '#E31A1C', '#FD8D3C', '#FED976']
    ];
}

function amplitudesEgales($data)
{
    $min = min($data);
    $max = max($data);
    $Q2 = (($max - $min) / 2) + $min;
    $Q1 = (($Q2 - $min) / 2) + $min;
    $Q3 = (($max - $Q2) / 2) + $Q2;

    return [
        'legende' => [$max, $Q3, $Q2, $Q1, $min],
        'colors' => ['#800026', '#E31A1C', '#FD8D3C', '#FED976']
    ];
}

function discretisation($cols, $algo = 'quantile')
{
    $results =  query("SELECT $cols as data FROM insee GROUP BY dep");
    $data = array_column($results, 'data');
    if ($algo == 'quantile')
        return quantile($data);
    return amplitudesEgales($data);
}

switch ($_GET['id']) {
    case 2:
        $data = discretisation("ROUND(SUM(p16_pop)/SUM(superf), 2)", $_GET['discretisation']);
        break;
}

echo json_encode($data);
