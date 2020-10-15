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
            round(min($data),2),
            round(percentile($data, 25),2),
            round(percentile($data, 50),2),
            round(percentile($data, 75),2),
            round(max($data),2)
        ],
        'colors' => ['#FED976', '#FD8D3C', '#E31A1C','#800026']
    ];
}

function amplitudesEgales($data)
{
    $min = round(min($data),2);
    $max = round(max($data),2);
    $Q2 = round((($max - $min) / 2) + $min,2);
    $Q1 = round((($Q2 - $min) / 2) + $min,2);
    $Q3 = round((($max - $Q2) / 2) + $Q2,2);

    return [
        'legende' => [$min, $Q1, $Q2, $Q3, $max],
        'colors' => ['#FED976', '#FD8D3C', '#E31A1C','#800026']
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
    case 3:
        $data = discretisation("SUM(p16_rsecocc)", $_GET['discretisation']);
        break;
}

echo json_encode($data);
