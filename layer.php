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

function geojsonSql($cols, $unite, $geom = 'geom'){
    return query("
        SELECT json_build_object(
            'type', 'FeatureCollection',
            'features', json_agg(
                json_build_object(
                    'type', 'Feature',
                    'geometry', ST_AsGeoJSON({$geom})::json,
                    'properties', json_build_object(
                        'nom_dpt', nom,
                        'code_dpt', code_dpt,
                        'data', data,
                        'unite', '{$unite}'
                    )
                )
            )
        ) as geojson
        FROM dpt a
        LEFT JOIN (
            SELECT dep, {$cols} as data
            FROM insee
            GROUP BY dep
        ) b ON a.code_dpt = b.dep
    ");
}

switch($_GET['id']){
    case 1:
        $geojson = geojsonSql("SUM(p16_pop)", "habitants", "ST_Centroid(geom)");
    break;
    case 2:
        $geojson = geojsonSql("ROUND(SUM(p16_pop)/SUM(superf),2)", "habitants/km²");
    break;
    case 3:
        $geojson = geojsonSql("SUM(p16_rsecocc)","résidences secondaires");
    break;
}

echo $geojson['0']['geojson'];
