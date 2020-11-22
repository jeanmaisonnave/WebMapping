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
       <div class="row align-items-center h-25 p-1 bg-light text-dark">
         <div class="container">
           <h1 class="text-center font-weight-bold">Jean Maisonnave</h1>
         </div>
        </div>
        <div class="row align-items-center h-75 bg-dark text-light selection">
          <div class="container">
            <h3 class="text-center m-3">Indicateurs</h3>
            <label for="couleurAnnee">Année</label>
            <select id= "selectAnnee" name="selectAnnee" class="col-4">
              <option value="1968">1968</option>
              <option value="1975">1975</option>
              <option value="1982">1982</option>
              <option value="1990">1990</option>
              <option value="1999">1999</option>
              <option value="2006">2006</option>
              <option value="2011">2011</option>
              <option value="2016">2016</option>
            </select>
            <h4 class="m-2">Aplats</h4>
            <ul class="list-group p-3">
              <a class="list-group-item indicateur" data-id="2" data-titre = "Densité de la population" data-type="aplat" href="#">Densité de la population (2016)</a>
              <a class="list-group-item indicateur" data-id="3" data-titre = "Nombre de résidences secondaires" data-type="aplat" href="#">Résidences secondaires (2016)</a>
            </ul>
            <label for="couleurPoly">Couleur</label>
            <select class="selectCouleur" name="couleurPoly" id="couleurPoly" class="col-4">
              <option value="red" style="background-color: #800026">red</option>
              <option value="blue" style="background-color:#2411F5ff">blue</option>
              <option value="green" style="background-color:#0F2B01ff">green</option>
            </select>
            <div class="form-group">
                <label>Discrétisation</label>
                <select class="form-control" name="discretisation">
                    <option value="amplitude">Amplitudes égales</option>
                    <option value="quantile">Quantiles</option>
                </select>
            </div>

            <h4 class="m-2">Cercles proportionnels</h4>

            <ul class="list-group p-3">
                <a class="list-group-item indicateur" data-id="1" data-titre="Population municipale" data-type="cercle" data-radius="50000" href="#">Population municipale (2016)</a>
                <a class="list-group-item indicateur" data-id="4" data-titre="Logements vacants" data-type="cercle" data-radius="50000" href="#">Logements vacants (2016)</a>
            </ul>
            <label for="couleurCercles">Couleur</label>
            <select class="selectCouleur" name="couleurCercles" id="couleurCercles" class="col-4">
              <option value="red" style="background-color: red">red</option>
              <option value="blue" style="background-color: blue">blue</option>
              <option value="green" style="background-color: green">green</option>
            </select>

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
