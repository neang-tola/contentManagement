<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Internal Web IT Solution</title>

    <!-- Bootstrap CSS -->    
    <link href="{{ URL::asset('public/backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="{{ URL::asset('public/backend/css/bootstrap-theme.css') }}" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="{{ URL::asset('public/backend/css/elegant-icons-style.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/backend/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="{{ URL::asset('public/backend/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('public/backend/css/style-responsive.css') }}" rel="stylesheet" />

</head>

  <body class="login-img3-body">

    @yield('content')

  </body>
</html>
