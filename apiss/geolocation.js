function initMap() {
        const maps = document.querySelectorAll('.map');

        for (let i = 0; i < maps.length; i++) {
          const map = maps[i];

          const directionsService = new google.maps.DirectionsService();
          const directionsRenderer = new google.maps.DirectionsRenderer();

          const mapOptions = {
            zoom: 15,
            center: new google.maps.LatLng(0, 0),
          };

          const mapInstance = new google.maps.Map(map, mapOptions);
          directionsRenderer.setMap(mapInstance);

          if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(
              function(position) {
                const uttn = new google.maps.LatLng(
                  position.coords.latitude,
                  position.coords.longitude
                );
                mapInstance.setCenter(uttn);
                calcRoute(uttn);
              },
              function(error) {
                console.log(error);
                alert("No se pudo obtener su ubicación");
              }, {
                enableHighAccuracy: true,
                timeout: 10000, 
                maximumAge: 0,
              }
            );
          } else {
            alert("La geolocalización no es soportada por su navegador");
          }

          function calcRoute(uttn) {
            const origin1 = uttn;
            const destination1 = new google.maps.LatLng(
                26.055476180585874, -98.26013281578827 
            );

            const request = {
              origin: origin1,
              destination: destination1,
              travelMode: "DRIVING",
            };

            directionsService.route(request, function(response, status) {
              if (status == "OK") {
                console.log(response);
                directionsRenderer.setDirections(response);
              }
            });
          }
        }
      }