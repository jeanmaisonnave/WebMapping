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



$(".indicateur").click(function(){
let type = $(this).data('type');
let id = $(this).data('id');
let discretisation = $("select[name='discretisation']").val();

	$.ajax({
		url: 'layer.php',
		data : {
			id : id
		},
		dataType: 'json',
		success: function (geojson) {
			if(layer){
				map.removeLayer(layer);
			}
      if (info){
        info.remove();
      }
      if (legend){
        legend.remove();
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
						console.log(data);
          drawAplat(geojson, data.legende, data.colors);
        }
				})
			} else {
				drawCercle(geojson);
			}
		}
	})

});

function drawAplat(geojson, legende, colors) {
	layer = L.geoJSON(geojson, {
		style: function (feature) {
			let fillColor = getColor(feature.properties.data, legende, colors);
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
    this._div.innerHTML = '<h4>Densité de la population</h4>' +  (props ?
      '<b>' + props.nom_dpt + '</b><br />' + props.data + ' hab / km²<sup>2</sup>'
      : '<p>Survolez un département</p>');
  };

  info.addTo(map);

  function highlightFeature(e) {
      var layerHover = e.target;

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
    drawLegend(map, legende, colors);
}

function drawCercle(geojson){
	layer = L.geoJSON(geojson, {
      pointToLayer: (feature, latlng) => {
        console.log(feature);
        if (feature) {
          return new L.Circle(latlng, {radius: feature.properties.data*0.02});
        }
      }
    })
      .bindPopup(popupHTML).addTo(map);
}

function popupHTML(layer) {
	let html = '<table class="table table-striped m-0">'
		+ '<tr><th>Nom</th><td>' + layer.feature.properties.nom_dpt + '</td></tr>'
		+ '<tr><th>Code</th><td>' + layer.feature.properties.code_dpt + '</td></tr>'
		+ '<tr><th>Données</th><td>' + layer.feature.properties.data + ' ' + layer.feature.properties.unite + '</td></tr>'
		+ '</table>';

	return html;
}

function getColor(d, legende, colors) {
	let color = null;
	$.each(legende, function (index, value) {
		if (d > parseFloat(value)) {
			color = colors[index - 1];
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

function drawLegend(map, legende, colors){
  legend = L.control({position: 'bottomright'});

  	legend.onAdd = function (map) {
			console.log(colors);
  		var div = L.DomUtil.create('div', 'info legend');

  		for (var i = 0; i < colors.length; i++) {
  			div.innerHTML +=
  				'<i style="background:' + colors[i] + '"></i> ' +
  				legende[i] + " - " + legende[i+1] + "<br>";
  		}
  		return div;
  	};

  	legend.addTo(map);
}
