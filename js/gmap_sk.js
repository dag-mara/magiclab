    // Custom Google Map
    function init_map() {
        var styles = [
            {'stylers':[{'saturation':-100}]},
            {'featureType': 'water','stylers':[{'color':'#AAAAAA'}]}
        ];
        var styledMap = new google.maps.StyledMapType(styles,{name: 'Magic Lab Map'});
        var mapOptions = {
            draggable: true,
            scrollwheel: false,
            zoom: magiclab_gmap_sk.zoom*1,
            streetViewControl:true,
            panControl: true,
            mapTypeControl: false,
            zoomControl: true,
            zoomControlOptions: {style: google.maps.ZoomControlStyle.LARGE},
            center: new google.maps.LatLng(magiclab_gmap_sk.center[0], magiclab_gmap_sk.center[1]),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');
        var marker = new google.maps.Marker({
            position:mapOptions.center,
            map:map,
            title:'Krátká 1134/14',
            icon:magiclab_gmap_sk.icon
        });

    }
    function load_map() {
        var script  = document.createElement('script');
        script.type = 'text/javascript';
        script.src  = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBzEPUL9S_akxIchUXO01Sk808yTD47W4I&callback=init_map';
        document.body.appendChild(script);
    }
    window.onload = load_map;