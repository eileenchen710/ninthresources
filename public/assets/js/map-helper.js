"use strict"; // Start of use strict

// 7. google map
function gMap () {
    if ($('.google-map').length) {
        $('.google-map').each(function () {
            // getting options from html 
            var mapName = $(this).attr('id');
            var mapLat = $(this).data('map-lat');
            var mapLng = $(this).data('map-lng');
            var iconPath = $(this).data('icon-path');
            var mapZoom = $(this).data('map-zoom');
            var mapTitle = $(this).data('map-title');

            // Use standard Google Maps theme (no custom styles)
            var styles = [];

            
            // if zoom not defined the zoom value will be 15;
            if (!mapZoom) {
                var mapZoom = 11;
            };
            // init map
            var map;
            map = new GMaps({
                div: '#'+mapName,
                scrollwheel: false,
                lat: mapLat,
                lng: mapLng,                
                styles: styles,
                zoom: mapZoom
            });
            // if icon path setted then show marker
            if(iconPath) {
                map.addMarker({
                    icon: iconPath,
                    lat: mapLat,
                    lng: mapLng,
                    title: mapTitle
                });
            }
        });  
    };
}



// instance of fuction while Document ready event   
jQuery(document).on('ready', function () {
    (function ($) {
        gMap();
    })(jQuery);
});
