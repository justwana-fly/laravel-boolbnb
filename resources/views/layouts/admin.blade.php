<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Boolpress')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
    
</head>

<body>
    <div id="admin">
        <div id="wrapper">
            @include('partials.sidebar')
            <main class="container">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function removeExpiredPromotions() {
                fetch('{{ route("admin.promotions.removeExpired") }}')
                    .then(response => response.json())
                    .then(data => {
                        console.log('Expired promotions removed:', data);
                    })
                    .catch(error => {
                        console.error('Error removing expired promotions:', error);
                    });
            }

            // Esegui la funzione subito e poi ogni minuto
            removeExpiredPromotions();
            setInterval(removeExpiredPromotions, 1 * 60 * 1000); // 1 minuto
        });
    </script>
    <script src="https://js.braintreegateway.com/web/dropin/1.28.0/js/dropin.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.89.1/js/client.min.js"></script>
    <script src="https://js.braintreegateway.com/web/3.89.1/js/hosted-fields.min.js"></script>
</body>

</html>
