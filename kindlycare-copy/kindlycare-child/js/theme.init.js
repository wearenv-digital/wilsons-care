/* global jQuery:false */
/* global KINDLYCARE_STORAGE:false */


// Theme-specific first load actions
//==============================================
function kindlycare_theme_ready_actions() {
    "use strict";
    // Put here your init code with theme-specific actions
    // It will be called before core actions
}


// Theme-specific scroll actions
//==============================================
function kindlycare_theme_scroll_actions() {
    "use strict";
    // Put here your theme-specific code with scroll actions
    // It will be called when page is scrolled (before core actions)
}


// Theme-specific resize actions
//==============================================
function kindlycare_theme_resize_actions() {
    "use strict";
    // Put here your theme-specific code with resize actions
    // It will be called when window is resized (before core actions)
}


// Theme-specific shortcodes init
//=====================================================
function kindlycare_theme_sc_init(cont) {
    "use strict";
    // Put here your theme-specific code to init shortcodes
    // It will be called before core init shortcodes
    // @param cont - jQuery-container with shortcodes (init only inside this container)
}


// Theme-specific post-formats init
//=====================================================
function kindlycare_theme_init_post_formats() {
    "use strict";
    // Put here your theme-specific code to init post-formats
    // It will be called before core init post_formats when page is loaded or after 'Load more' or 'Infinite scroll' actions
}


// Theme-specific GoogleMap styles
//=====================================================
function kindlycare_theme_googlemap_styles($styles) {
    "use strict";
    // Put here your theme-specific code to add GoogleMap styles
    // It will be called before GoogleMap init when page is loaded
    $styles['greyscale'] = [
        {
            "stylers": [
                {"saturation": -100}
            ]
        }
    ];
    $styles['inverse'] = [
        {
            "stylers": [
                {"invert_lightness": true},
                {"visibility": "on"}
            ]
        }
    ];
    $styles['simple'] = [
        {
            stylers: [
                {hue: "#00ffe6"},
                {saturation: -20}
            ]
        },
        {
            featureType: "road",
            elementType: "geometry",
            stylers: [
                {lightness: 100},
                {visibility: "simplified"}
            ]
        },
        {
            featureType: "road",
            elementType: "labels",
            stylers: [
                {visibility: "off"}
            ]
        }
    ];
    $styles['light'] = [{
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [{"color": "#444444"}]
    }, {
        "featureType": "administrative.locality",
        "elementType": "labels",
        "stylers": [{"visibility": "on"}]
    }, {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [{"color": "#f2f2f2"}, {"visibility": "simplified"}]
    }, {"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "on"}]}, {
        "featureType": "poi",
        "elementType": "geometry",
        "stylers": [{"visibility": "simplified"}, {"saturation": "-65"}, {"lightness": "45"}, {"gamma": "1.78"}]
    }, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "off"}]}, {
        "featureType": "poi",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "road",
        "elementType": "all",
        "stylers": [{"saturation": -100}, {"lightness": 45}]
    }, {"featureType": "road", "elementType": "labels", "stylers": [{"visibility": "on"}]}, {
        "featureType": "road",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [{"visibility": "simplified"}]
    }, {
        "featureType": "road.highway",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "transit.line",
        "elementType": "geometry",
        "stylers": [{"saturation": "-33"}, {"lightness": "22"}, {"gamma": "2.08"}]
    }, {
        "featureType": "transit.station.airport",
        "elementType": "geometry",
        "stylers": [{"gamma": "2.08"}, {"hue": "#ffa200"}]
    }, {
        "featureType": "transit.station.airport",
        "elementType": "labels",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "transit.station.rail",
        "elementType": "labels.text",
        "stylers": [{"visibility": "off"}]
    }, {
        "featureType": "transit.station.rail",
        "elementType": "labels.icon",
        "stylers": [{"visibility": "simplified"}, {"saturation": "-55"}, {"lightness": "-2"}, {"gamma": "1.88"}, {"hue": "#ffab00"}]
    }, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#bbd9e5"}, {"visibility": "simplified"}]}
    ];
    return $styles;
}
