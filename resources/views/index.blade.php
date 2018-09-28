<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <!-- <link rel="stylesheet" href="//cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css"> -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <style>
            #page-preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1000;
                background: #fff;
            }
            #page-preloader .spinner {
                width: 300px;
                height: 300px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                display: block;
            }
            #page-preloader .spinner .logo {
                width: 100%;
                height: 100%;
                background: url("{{ asset('images/preloader.gif') }}") center center no-repeat;
                background-size: contain;
            }
            @keyframes fadeOut {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 0;
                }
            }
        </style>
    </head>
    <body>
        <div id="page-preloader">
            <span class="spinner">
                <div class="logo"></div>
            </span>
        </div>

        <div id="app"></div>

        <script>
            console.log('HELLO');
            document.body.onload = function() {
                var preloader = document.getElementById('page-preloader');
                setTimeout(function() {
                    preloader.style.animation = 'fadeOut 1s';
                    setTimeout(function() {
                        preloader.style.display = 'none';
                    }, 1000)
                }, 1000);
            };
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
