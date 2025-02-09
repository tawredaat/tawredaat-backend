<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <title>@yield('page-title')</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#23408D">
    <meta name="description" content="@yield('page-description')">
    <meta name="keywords" content="@yield('page-keywords')">
    <meta name="tags" content="@yield('page-tags')">
    <meta name="meta_title" content="@yield('page-meta_title')">
    <meta name="og:image" content="@yield('page-image')" />
    @yield('homePage-seo')
    @if (App::isLocale('en'))
        <link rel="stylesheet" href="{{ asset('frontend_plugins/web/packages//bootstrap/css/bootstrap.min.css') }}" />
    @elseif(App::isLocale('ar'))
        <link rel="stylesheet"
            href="{{ asset('frontend_plugins/web/packages//bootstrap/css/bootstrap-rtl.min.css') }}" />
        <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

        <style type="text/css">
            body {
                font-family: 'Cairo', sans-serif;
            }
        </style>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('frontend_plugins/web/stylesheet/css/style.css') }}" />
    <link rel="shortcut icon"
        href="{{ asset('frontend_plugins/assets/app/media/img/cropped-FavIcon-Tawredaat.jpeg') }} " />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="canonical" href="@yield('canonical-link')" />
    <link rel="alternate" hreflang='en-eg' href="@yield('alternate-en-link')" />
    <link rel="alternate" hreflang='ar-eg' href="@yield('alternate-ar-link')" />
    @yield('pagination-links')
    <style type="text/css">
        .modal-backdrop.show {
            opacity: 0 !important;
        }
    </style>
    <style>
        /* Style The Dropdown Button */
        .dropbtn {
            color: #000;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            width: 100%;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #F7CB14
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    @stack('style')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136842843-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-136842843-1');
    </script>
    <script type="application/ld+json">
        {
          "@context": "https://schema.org/",
          "@type": "WebSite",
          "name": "Souq Kahraba",
          "url": "https://souqkahraba.com/",
          "potentialAction": {
            "@type": "SearchAction",
            "target": "https://souqkahraba.com/search?search_type={search_term_string}",
            "query-input": "required name=search_term_string"
            }
        }
       </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '424148452222338');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
            src="https://www.facebook.com/tr?id=424148452222338&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '997296877675070');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
            src="https://www.facebook.com/tr?id=997296877675070&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body {{ App::isLocale('ar') ? 'class=rtl' : '' }} class="">
    <div class="loading">
    </div>
    <div class="root">
        <div class="home-wrapper product-wrapper brand-wrapper company-wrapper search-wrapper">
            <!-- start header -->
            <header class="main-header" id="header">
                @include('User.partials.header')
            </header>
            <!-- start page content -->
            @if (!isLogged())
                @include('User.Modals.login')
            @endif
            @if (isLogged())
                @include('User.Modals.accCreated')
                @include('User.Modals.bestPrice')
                @include('User.Modals.bestSellingPriceSent')
            @endif

            @yield('content')
            <!-- start footer -->
            <footer class="footer-holder" id="footer">
                @include('User.partials.footer')
            </footer>
        </div>
    </div>
    <script src="{{ asset('frontend_plugins/web/packages/jquery/jquery.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/packages/lazysizes/lazysizes.min.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/packages/bootstrap/js/propper.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/packages/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/packages/slick/javascript/slick.min.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/javascript/global.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/javascript/filter.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/javascript/shop.js') }}"></script>
    <script src="{{ asset('frontend_plugins/web/javascript/checkout.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js">
        < script src = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js"
        integrity = "sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw=="
        crossorigin = "anonymous" >
    </script>
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (isset($lang_changed) && $lang_changed)
                localStorage.removeItem("shopWebSouq");
                localStorage.removeItem("shopMobileSouq");
            @endif
            var shopWebSouq = localStorage.getItem("shopWebSouq");
            var shopMobileSouq = localStorage.getItem("shopMobileSouq");
            if (shopMobileSouq === null && shopWebSouq === null) {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('user.all.categories') }}",
                    success: function(data) {
                        localStorage.setItem("shopMobileSouq", data['categoriesMobile']);
                        localStorage.setItem("shopWebSouq", data['categoriesWeb']);
                        $("#categoriesWeb").append(data['categoriesWeb']);
                        $("#navAccordion").append(data['categoriesMobile']);
                    }
                });
            } else {
                $("#categoriesWeb").append(shopWebSouq);
                $("#navAccordion").append(shopMobileSouq);
            }
        });

        function clearShopCache() {
            localStorage.removeItem("shopWebSouq");
            localStorage.removeItem("shopMobileSouq");
        }
        setInterval(clearShopCache, 60 * 60 * 1000);
    </script>
    <script>
        $(function() {
            $('.tabs-header-button').click(function(e) {
                e.preventDefault();
                let active_tab = $(this).attr("data-target");
                console.log(active_tab)
                $(".auth-tabs-body, .tabs-header-button").removeClass("active");
                $(`.auth-tabs-body[data-tab="${active_tab}"], .tabs-header-button[data-target="${active_tab}"]`)
                    .addClass("active");

            });
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        });
        @if (session()->has('accCreated') > 0)
            $('#accCreated').modal('show');
        @endif
    </script>
    @stack('script')
    @include('User.partials.messages')
</body>

</html>
