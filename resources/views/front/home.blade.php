<x-front-layout>



    <!-- Start Trending Product Area -->

    <section class="trending-product section">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Our Products</h2>
                    </div>
                </div>
            </div>
            <nav aria-label="Page navigation">
                {{ $products->withQueryString()->links() }}

            </nav>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Start Single Product -->
                        <div class="single-product">
                            <x-product-card :product="$product" />
                        </div>
                        <!-- End Single Product -->
                    </div>
                @endforeach
            </div>
            <nav aria-label="Page navigation">
                {{ $products->withQueryString()->links() }}

            </nav>
        </div>

    </section>

    <!-- End Trending Product Area -->


    <!-- End Trending Product Area -->


    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->

    @push('scripts')
        <!-- ========================= JS here ========================= -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/tiny-slider.js"></script>
        <script src="assets/js/glightbox.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script type="text/javascript">
            //========= Hero Slider 
            tns({
                container: '.hero-slider',
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 0,
                items: 1,
                nav: false,
                controls: true,
                controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            });

            //======== Brand Slider
            tns({
                container: '.brands-logo-carousel',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 15,
                nav: false,
                controls: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    540: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
        </script>
        <script>
            const finaleDate = new Date("February 15, 2023 00:00:00").getTime();

            const timer = () => {
                const now = new Date().getTime();
                let diff = finaleDate - now;
                if (diff < 0) {
                    document.querySelector('.alert').style.display = 'block';
                    document.querySelector('.container').style.display = 'none';
                }

                let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                let hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                let minutes = Math.floor(diff % (1000 * 60 * 60) / (1000 * 60));
                let seconds = Math.floor(diff % (1000 * 60) / 1000);

                days <= 99 ? days = `0${days}` : days;
                days <= 9 ? days = `00${days}` : days;
                hours <= 9 ? hours = `0${hours}` : hours;
                minutes <= 9 ? minutes = `0${minutes}` : minutes;
                seconds <= 9 ? seconds = `0${seconds}` : seconds;

                document.querySelector('#days').textContent = days;
                document.querySelector('#hours').textContent = hours;
                document.querySelector('#minutes').textContent = minutes;
                document.querySelector('#seconds').textContent = seconds;

            }
            timer();
            setInterval(timer, 1000);
        </script>
    @endpush
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            /* يخليها في النص */
            flex-wrap: wrap;
            /* لو الشاشة صغيرة تنزل سطر جديد */
            margin-top: 20px;
        }

        .page-item {
            margin: 0 5px;
            /* مسافة بين الأزرار */
        }

        .page-link {
            color: #007bff;
            border: 1px solid #dee2e6;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .page-link:hover {
            background-color: #f0f0f0;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
    </style>

</x-front-layout>
