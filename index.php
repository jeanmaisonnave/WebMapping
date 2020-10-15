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
<body>
  <div class="container-fluid h-100">
   <div class="row h-100">
     <div id="menu" class="col-3 p-0">
       <div class="row align-items-center h-25 p-1 bg-dark text-white">
         <div class="container">
           <h1 class="text-center font-weight-bold">Jean Maisonnave</h1>
           <p class="text-center font-italic">Master 2 Siglis - Web Mapping<br>Contact : <a href="mailto:jeanmaisonnave@wanadoo.fr" class="font-italic text-white"><u>jeanmaisonnave@wanadoo.fr</u></a></p>
         </div>
        </div>
        <div class="row align-items-center h-75 selection">
          <div class="container">
            <h3 class="text-center text-primary m-3">Indicateurs</h3>

            <h4 class="text-info m-2">Cercles proportionnels</h4>
            <ul class="list-group p-3">
                <a class="list-group-item indicateur" data-id="1" data-type="cercle" data-radius="50000" href="#">Population municipale (2016)</a>
            </ul>

            <h4 class="text-info m-2">Aplats</h4>
            <ul class="list-group p-3">
              <a class="list-group-item indicateur" data-id="2" data-type="aplat" href="#">Densité de la population (2016)</a>
              <a class="list-group-item indicateur" data-id="3" data-type="aplat" href="#">Résidences secondaires (2016)</a>
              <select name="anneePopMuni" data-id="1" class="col-4">
                <option value="" selected>Année</option>
                <option value="d68">1968</option>
                <option value="d75">1975</option>
                <option value="d82">1982</option>
                <option value="d90">1990</option>
                <option value="d99">1999</option>
                <option value="p06">2006</option>
                <option value="p11">2011</option>
                <option value="p16">2016</option>
              </select>
            </ul>
            <div class="form-group">
                <label>Discrétisation</label>
                <select class="form-control" name="discretisation">
                    <option value="amplitude">Amplitudes égales</option>
                    <option value="quantile">Quantiles</option>
                </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="mapid"></div>
</div>

  <script src="main.js"></script>
</body>

</html>
