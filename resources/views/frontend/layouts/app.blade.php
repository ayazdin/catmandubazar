<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="description" content="@yield('description')">

    <meta property="og:site_name" content="{{ config('app.name') }} "/>
    <meta property="og:title" content="@yield('title')"/>
    <meta property="og:description" content="@yield('description')"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="@yield('url')"/>
    <meta property="og:image" content="@yield('image')"/>
    {{--<link rel="icon" href="../../favicon.ico">--}}

    <title>@yield('title')</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="{{url('/frontend/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{url('/frontend/css/style.css')}}" rel="stylesheet">
    <link href="{{url('/frontend/css/custom.css')}}" rel="stylesheet">
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=1536813856603295&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@include('frontend/includes.header')

<div class="container mar-top-40">
    <div class="latest-news">
        <div class="row">
            <div class="col-sm-12">
                @yield('content')

            </div>
        </div>
    </div>
</div>

@include('frontend/includes.footer')


        <!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="{{url('/frontend/js/bootstrap.min.js')}}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{url('/frontend/js/ie10-viewport-bug-workaround.js')}}"></script>
<script>
    $(function () {
        $('#imgCarousel').on('slide.bs.carousel', function (e) {
            console.log(e.direction);
            if(e.direction=='left')
                $('#txtCarousel').carousel('next'); // Will slide to the slide 2 as soon as the transition to slide 1 is finished
            else {
                $('#txtCarousel').carousel('prev')
            }
        })
    });
</script>
</body>
</html>
