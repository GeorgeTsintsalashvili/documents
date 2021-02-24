
       <!DOCTYPE html>

       <html lang="ka">

         <head>

           <!-- Meta, title, CSS -->

           <title>@yield('title')</title>

           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1">
           <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

           <!-- CSRF Token -->

           <meta name="csrf-token" content="{{ csrf_token() }}">

           <!-- Font Awesome -->

           <link href="/fonts/font-awesome/css/all.min.css" rel="stylesheet">

           <!-- Custom Style -->

           <link href="/css/auth.css" rel="stylesheet">

           <!--- Company logo --->

           <link rel="icon" href="/images/general/logo.ico">

           <!--- Vendros scripts --->

           <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>

         </head>

         <body class="page">

            <!-- Page content start-->

            @yield('content')

            <!-- Page content end-->

         </body>
       </html>
