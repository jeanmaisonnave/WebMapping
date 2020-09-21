<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./index.css" />
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
  <title>Jean Maisonnave</title>
</head>
<h2 style="color:red;">Jean Maisonnave</h2>
<body>
  <div id="menu" class="py-2">
        <h3 class="text-center text-primary m-3">Indicateurs</h3>

        <h4 class="text-info m-2">Cercles proportionnels</h4>
        <ul class="list-group p-3">
            <a class="list-group-item indicateur" data-id="1" data-type="cercle" data-radius="50000" href="#">Population municipale (2016)</a>
        </ul>

        <h4 class="text-info m-2">Aplats</h4>
        <ul class="list-group p-3">
            <a class="list-group-item indicateur" data-id="2" data-type="aplat" href="#">Densité de la population (2016)</a>
        </ul>

        <div class="form-group">
            <label>Discrétisation</label>
            <select class="form-control" name="discretisation">
                <option value="amplitude">Amplitudes égales</option>
                <option value="quantile">Quantiles</option>
            </select>
        </div>
    </div>
  <div id="mapid"></div>

  <script src="main.js"></script>
</body>

</html>
