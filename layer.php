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
$resget = $_GET['annee'];
$codeAnnee='';
(int)$resget < 2000 ? $codeAnnee ="d" . substr($resget,2) : $codeAnnee="p" . substr($resget,2);

switch($_GET['id']){
    case 1:
        $geojson = geojsonSql("SUM(".$codeAnnee."_pop)", "habitants", "ST_Centroid(geom)");
        break;
    case 2:
        $geojson = geojsonSql("ROUND(SUM(".$codeAnnee."_pop)/SUM(superf),2)", "habitants/km²");
        break;
    case 3:
        $geojson = geojsonSql("ROUND(SUM(".$codeAnnee."_rsecocc),0)","résidences secondaires");
        break;
    case 4:
        $geojson = geojsonSql("ROUND(SUM(".$codeAnnee."_logvac),0)","logements vacants", "ST_Centroid(geom)");
        break;
}

echo $geojson['0']['geojson'];
