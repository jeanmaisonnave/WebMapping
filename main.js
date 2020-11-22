var map = L.map("mapid").setView([46.370352, 2.591507], 6);
var layer = null;
var info = null;
var legend = null;
infoExists = false;
L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
	subdomains: 'abcd',
	maxZoom: 19
  }
).addTo(map);

L.control.scale().addTo(map);

$(".indicateur").on('click',dessinerIndicateur);

function dessinerIndicateur(){
let type = $(this).data('type');
let id = $(this).data('id');
let titre = $(this).data('titre');
let discretisation = $("select[name='discretisation']").val();
let annee = $("select[name='selectAnnee']").val();

 $.ajax({
		url: 'layer.php',
		data : {
			id : id,
			annee : annee
		},
		dataType: 'json',
		success: function (geojson) {
			if(layer){
				if (info){
	        info.remove();
	      }
				if (legend){
	        legend.remove();
	      }
				map.removeLayer(layer);
			}

      if (type === 'aplat') {
				$.ajax({
					url: 'discretisation.php',
					data: {
						id : id,
						discretisation: discretisation
					},
					dataType: 'json',
					success: function (data) {
          drawAplat(geojson, data.legende, titre);
        }
				})
			} else {
				drawCercle(geojson, id, titre);
			}
		}

	})
}


//dessin Applat
function drawAplat(geojson, legende, titre) {
	layer = L.geoJSON(geojson, {
		style: function (feature) {
			let fillColor = getColor(feature.properties.data, legende);
			return {
				fillColor: fillColor,
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '3',
				fillOpacity: 0.7
			};
		},
		onEachFeature : onEachFeature
	}).bindPopup(popupHTML).addTo(map);

  info = L.control();

  info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };

  info.update = function (props) {
    this._div.innerHTML = '<h4>'+ titre +'</h4>' +  (props ?
      '<b>' + props.nom_dpt + '</b><br />' + props.data + ' ' + props.unite
      : '<p>Survolez un département</p>');
  };

  info.addTo(map);

  function highlightFeature(e) {
		  console.log("poly highlight");
      var layerHover = e.target;
			console.log(layerHover);
      layerHover.setStyle({
        weight: 5,
        color: '#666',
        dashArray: '',
        fillOpacity: 0.7
      });

      if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
        layerHover.bringToFront();
      }

      info.update(layerHover.feature.properties);
    }

  function resetHighlight(e) {
      layer.resetStyle(e.target);
      info.update();
    }


    function onEachFeature(feature, layerHover) {
      layerHover.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight
      });
    }
    drawLegend(map, legende);
}

//dessin cercle
function drawCercle(geojson, id, titre){
	let coef = null;
	let col = null;
	let couleur = $("#couleurCercles").val();
	switch (id){
		case 1:
			coef = 0.02;
			break;
		case 4:
			coef = 0.5;
			break;
	}
	layer = L.geoJSON(geojson, {
      pointToLayer: (feature, latlng) => {
        console.log(feature);
        if (feature) {
          return new L.Circle(latlng, {
						radius: feature.properties.data*coef,
						color: couleur
					});
        }
      },
			onEachFeature : onEachFeature
    })
      .bindPopup(popupHTML).addTo(map);

		info = L.control();

		info.onAdd = function (map) {
	    this._div = L.DomUtil.create('div', 'info');
	    this.update();
	    return this._div;
	  };

	  info.update = function (props) {
	    this._div.innerHTML = '<h4>'+ titre +'</h4>' +  (props ?
	      '<b>' + props.nom_dpt + '</b><br />' + props.data + ' ' + props.unite
	      : '<p>Survolez un département</p>');
	  };

	  info.addTo(map);

	  function highlightFeature(e) {
				console.log("cercle highlight");
	      var layerHover = e.target;
				console.log(layerHover);
	      layerHover.setStyle({
	        weight: 5,
	        color: '#666',
	        dashArray: '',
	        fillOpacity: 0.7
	      });

	      if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
	        layerHover.bringToFront();
	      }

	      info.update(layerHover.feature.properties);
	    }

	  function resetHighlight(e) {
	      layer.resetStyle(e.target);
	      info.update();
	    }


	    function onEachFeature(feature, layerHover) {
	      layerHover.on({
	        mouseover: highlightFeature,
	        mouseout: resetHighlight
	      });
	    }
}


//popup
function popupHTML(layer) {
	let html = '<table class="table table-striped m-0">'
		+ '<tr><th>Nom</th><td>' + layer.feature.properties.nom_dpt + '</td></tr>'
		+ '<tr><th>Code</th><td>' + layer.feature.properties.code_dpt + '</td></tr>'
		+ '<tr><th>Données</th><td>' + layer.feature.properties.data + ' ' + layer.feature.properties.unite + '</td></tr>'
		+ '</table>';

	return html;
}

function getColor(d, legende) {
	let color = null;
	palette = getPalette();
	$.each(legende, function (index, value) {
		if (d <= parseFloat(value)) {
			color = palette[index - 1];
			return false;
		}
	});
	return color;
}

function style(feature) {
		return {
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.7,
			fillColor: getColor(feature.properties.data)
		};
	}

function getPalette() {
	let couleur = $("#couleurPoly").val();
	const palette =
	{
		"red" : ['#FED976', '#FD8D3C', '#E31A1C','#800026'],
		"blue" : ['#95F4FFff', '#6FA8FCff', '#4A5DF8ff','#2411F5ff'],
		"green" : ['#027800ff', '#065E00ff', '#0B4501ff','#0F2B01ff']
 	}
	return palette[couleur];
}

//légende
function drawLegend(map, legende){
	palette = getPalette();
  legend = L.control({position: 'bottomright'});

  	legend.onAdd = function (map) {
  		var div = L.DomUtil.create('div', 'info legend');
  		for (var i = 0; i < palette.length; i++) {
  			div.innerHTML +=
  				'<i style="background:' + palette[i] + '"></i> ' +
  				legende[i] + " - " + legende[i+1] + "<br>";
  		}
  		return div;
  	};
  	legend.addTo(map);
}
