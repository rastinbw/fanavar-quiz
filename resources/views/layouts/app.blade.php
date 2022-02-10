<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <script src="{{asset('js/jquery.min.js')}}"></script> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Fanavar Quiz</title>
</head>


<style type="text/css">
    @font-face {
        font-family: IRANSans;
        font-style: normal;
        font-weight: bold;
        src:url("{{ asset('fonts/IRANSansWeb_Light.eot') }}");
        src: url("{{ asset('fonts/IRANSansWeb_Lightd41d.eot?#iefix') }}") format('embedded-opentype'),  /* IE6-8 */
            url("{{ asset('fonts/IRANSansWeb_Light.woff2') }}") format('woff2'),  /* FF39+,Chrome36+, Opera24+*/
            url("{{ asset('fonts/IRANSansWeb_Light.woff') }}") format('woff'),  /* FF3.6+, IE9, Chrome6+, Saf5.1+*/
            url("{{ asset('fonts/IRANSansWeb_Light.ttf') }}") format('truetype');
    }

    html,
    body {
        font-family: 'IRANSans';
        height: 100%;
    }

    #navbar ul {
        padding: 10px;
        margin: 0;
        list-style-type: none;
        text-align: end;
        background-color: rgb(216, 89, 89);
    }

    #navbar ul li {
        display: inline;
    }

    #navbar ul li a {
        text-decoration: none;
        padding: .2em 1em;
        color: #fff;
        background-color: rgb(216, 89, 89);
    }

    #navbar ul li a:hover {
        /* color: rgb(255, 255, 255); */
        /* background-color: rgb(211, 42, 42); */
    }

</style>

@stack('style')


<body>
    <div id="navbar">
        <ul>
            <?php $name = Auth::user()->name?>
            <li style="float: left"><i class="bi bi-arrow-right-square"></i> <a href="{{ URL::to('logout') }}">خروج از حساب کاربری</a></li>
            <li><i class="bi bi-arrow-right-square"></i> <a href="{{ URL::to('profile') }}">{{ $name }}</a></li>
        </ul>
    </div>

    @yield('content')

    @stack('child-scripts')
</body>


</html>
