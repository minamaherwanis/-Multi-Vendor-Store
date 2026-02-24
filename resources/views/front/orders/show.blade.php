<x-front-layout title="Order Details">

    <x-slot:breadcrumb>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Order # {{ $order->number }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="#">Orders</a></li>
                            <li>Order # {{ $order->number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:breadcrumb>

    <section class="checkout-wrapper section">
        <div class="container">
            <div id="map" style="height: 50vh;"></div>
        </div>
    </section>

    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script>
        var map, marker;

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('d372510b97fe6b07fdbb', {
            cluster: 'eu',
            channelAuthorization: {
                endpoint: "/broadcasting/auth",
                headers: {
                    "X-CSRF-Token": "{{ csrf_token() }}"
                }
            }
        });

        var channel = pusher.subscribe('private-deliveries.{{ $order->id }}');

        channel.bind('location-updated', function(data) {
            alert("New location: " + data.latitude + ", " + data.longitude);
            if (marker) {
                marker.setPosition({
                    lat: Number(data.latitude),
                    lng: Number(data.longitude)
                });
            }
        });

        // Initialize and add the map
        function initMap() {
            const location = {
                lat: Number("{{ $order->delivery->latitude }}"),
                lng: Number("{{ $order->delivery->longitude }}")
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 11,
                center: location,
            });

            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }

        window.initMap = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.maps_key') }}" defer></script>

</x-front-layout>