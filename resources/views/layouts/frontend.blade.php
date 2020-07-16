<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TeleRadiology</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="" dir="rtl">
    <div class="container-fluid">
        <header class="row">
            <div class="col">
                @include('frontend.partials.header.navbar')
            </div>
        </header>
        <div class="row">
            <div class="col">
                @yield('content')
            </div>
        </div>
        <footer class="row">
            <div class="col">
                @include('frontend.partials.footer.footer')
            </div>
        </footer>
    </div>
<script type="text/javascript" src="/js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/js/bootstrap1.min.js"></script>
</body>
</html>
