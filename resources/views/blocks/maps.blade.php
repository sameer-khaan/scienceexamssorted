{{--
  Title: Maps
  Description: Map with text block.
  Category: thync
  Icon: admin-site
  Keywords: map maps google content text
  Mode: edit
  Align: full
  SupportsAlign: false
  SupportsMode: true
  SupportsMultiple: true
--}}
<div class="full-width" data-{{$block['id']}}>
    <div class="map-widget">
        <div class="map-holder" id="map" data-lat="{{ get_field('lat') }}" data-long="{{ get_field('lng') }}"></div>
    </div>
</div>
@section('scripts')
  <script type="text/javascript">
        var map;
        function initMap() {
          var map_element = document.getElementById('map');
          if(map_element != null && map_element.length !== 0) {
            var myLatLng = {
              lat: Number(map_element.getAttribute("data-lat")),
              lng: Number(map_element.getAttribute("data-long"))
            };

            var map = new google.maps.Map(document.getElementById('map'), {
              zoom: 15,
              center: myLatLng,
              mapTypeControl: false,
              streetViewControl: false,
              fullscreenControl: false,
              zoomControlOptions: {
                  position: google.maps.ControlPosition.LEFT_BOTTOM
              },
              styles: [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2efe4"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#2d3f24"
            },
            {
                "visibility": "on"
            }
        ]
    }
]
            });

            var marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              icon: get_marker_image(),
            });

            google.maps.event.addDomListener(window, "resize", function() {
              marker.setIcon(get_marker_image());
            });

            function get_marker_image() {

                var image = {
                  url: '{{ get_field('map_marker', 'option') }}',
                  scaledSize: new google.maps.Size(54, 72),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(27,72)
                };
                map.panTo(myLatLng);
                map.panBy(0, -20);

              return image;
            }
          }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ get_field('google_maps_api_key', 'option') }}&callback=initMap" async defer></script>
@endsection