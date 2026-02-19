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
            <!-- عنصر الخريطة -->
            <div id="map" style="height:50vh; width:100%;"></div>
        </div>
    </section>

    <script>
        function initMap() {
            // deliveryالإحداثيات من علاقة 
            const location = {
                lat: Number("{{ $order->delivery->latitude }}"),
                lng: Number("{{ $order->delivery->longitude }}")
            };

            // إنشاء الخريطة
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: location,
            });

            // إضافة ماركر
            new google.maps.Marker({
                position: location,
                map: map,
                title: "Delivery Location"
            });
        }

        window.initMap = initMap;
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPQG8tc7i_C_L6E-0OrASnDFjqaG52bJc&callback=initMap&v=weekly" defer></script>

</x-front-layout>