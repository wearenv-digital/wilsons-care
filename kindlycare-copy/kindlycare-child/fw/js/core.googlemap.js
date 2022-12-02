function kindlycare_googlemap_init(dom_obj, coords) {
	"use strict";
	if (typeof KINDLYCARE_STORAGE['googlemap_init_obj'] == 'undefined') kindlycare_googlemap_init_styles();
	KINDLYCARE_STORAGE['googlemap_init_obj'].geocoder = '';
	try {
		var id = dom_obj.id;
		KINDLYCARE_STORAGE['googlemap_init_obj'][id] = {
			dom: dom_obj,
			markers: coords.markers,
			geocoder_request: false,
			opt: {
				zoom: coords.zoom,
				center: null,
				scrollwheel: false,
				scaleControl: false,
				disableDefaultUI: false,
				panControl: true,
				zoomControl: true, //zoom
				mapTypeControl: false,
				streetViewControl: false,
				overviewMapControl: false,
				styles: KINDLYCARE_STORAGE['googlemap_styles'][coords.style ? coords.style : 'default'],
				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		};
		
		kindlycare_googlemap_create(id);

	} catch (e) {
		
		//dcl(KINDLYCARE_STORAGE['strings']['googlemap_not_avail']);

	};
}

function kindlycare_googlemap_create(id) {
	"use strict";

	// Create map
	KINDLYCARE_STORAGE['googlemap_init_obj'][id].map = new google.maps.Map(KINDLYCARE_STORAGE['googlemap_init_obj'][id].dom, KINDLYCARE_STORAGE['googlemap_init_obj'][id].opt);

	// Add markers
	for (var i in KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers)
		KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].inited = false;
	kindlycare_googlemap_add_markers(id);
	
	// Add resize listener
	jQuery(window).resize(function() {
		if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].map)
			KINDLYCARE_STORAGE['googlemap_init_obj'][id].map.setCenter(KINDLYCARE_STORAGE['googlemap_init_obj'][id].opt.center);
	});
}

function kindlycare_googlemap_add_markers(id) {
	"use strict";
	for (var i in KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers) {
		
		if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].inited) continue;
		
		if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].latlng == '') {
			
			if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].geocoder_request!==false) continue;
			
			if (KINDLYCARE_STORAGE['googlemap_init_obj'].geocoder == '') KINDLYCARE_STORAGE['googlemap_init_obj'].geocoder = new google.maps.Geocoder();
			KINDLYCARE_STORAGE['googlemap_init_obj'][id].geocoder_request = i;
			KINDLYCARE_STORAGE['googlemap_init_obj'].geocoder.geocode({address: KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].address}, function(results, status) {
				"use strict";
				if (status == google.maps.GeocoderStatus.OK) {
					var idx = KINDLYCARE_STORAGE['googlemap_init_obj'][id].geocoder_request;
					if (results[0].geometry.location.lat && results[0].geometry.location.lng) {
						KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = '' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng();
					} else {
						KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[idx].latlng = results[0].geometry.location.toString().replace(/\(\)/g, '');
					}
					KINDLYCARE_STORAGE['googlemap_init_obj'][id].geocoder_request = false;
					setTimeout(function() { 
						kindlycare_googlemap_add_markers(id); 
						}, 200);
				} else
					dcl(KINDLYCARE_STORAGE['strings']['geocode_error'] + ' ' + status);
			});
		
		} else {
			
			// Prepare marker object
			var latlngStr = KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].latlng.split(',');
			var markerInit = {
				map: KINDLYCARE_STORAGE['googlemap_init_obj'][id].map,
				position: new google.maps.LatLng(latlngStr[0], latlngStr[1]),
				clickable: KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].description!=''
			};
			if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].point) markerInit.icon = KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].point;
			if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].title) markerInit.title = KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].title;
			KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].marker = new google.maps.Marker(markerInit);
			
			// Set Map center
			if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].opt.center == null) {
				KINDLYCARE_STORAGE['googlemap_init_obj'][id].opt.center = markerInit.position;
				KINDLYCARE_STORAGE['googlemap_init_obj'][id].map.setCenter(KINDLYCARE_STORAGE['googlemap_init_obj'][id].opt.center);				
			}
			
			// Add description window
			if (KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].description!='') {
				KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].infowindow = new google.maps.InfoWindow({
					content: KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].description
				});
				google.maps.event.addListener(KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].marker, "click", function(e) {
					var latlng = e.latLng.toString().replace("(", '').replace(")", "").replace(" ", "");
					for (var i in KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers) {
						if (latlng == KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].latlng) {
							KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].infowindow.open(
								KINDLYCARE_STORAGE['googlemap_init_obj'][id].map,
								KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].marker
							);
							break;
						}
					}
				});
			}
			
			KINDLYCARE_STORAGE['googlemap_init_obj'][id].markers[i].inited = true;
		}
	}
}

function kindlycare_googlemap_refresh() {
	"use strict";
	for (id in KINDLYCARE_STORAGE['googlemap_init_obj']) {
		kindlycare_googlemap_create(id);
	}
}

function kindlycare_googlemap_init_styles() {
	// Init Google map
	KINDLYCARE_STORAGE['googlemap_init_obj'] = {};
	KINDLYCARE_STORAGE['googlemap_styles'] = {
		'default': []
	};
	if (window.kindlycare_theme_googlemap_styles!==undefined)
		KINDLYCARE_STORAGE['googlemap_styles'] = kindlycare_theme_googlemap_styles(KINDLYCARE_STORAGE['googlemap_styles']);
}