<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="vnzacky39@gmail.com">
    <title>@yield('title', 'Facebook')</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <style>
        body {
            padding: 20px 0 0;
            background-color: #3c3c3c;
            color: #FFF;
        }
        .container{
            max-width: 960px;
            margin: 0 auto;
        }
        .copyright {
            margin-top: 30px;
            padding-top: 30px;
            padding-bottom: 30px;
            border-top: 1px solid #dedede;;
        }
        .required {
            color: darkred;
        }
        .title {
            text-align: center;
        }
    </style>

</head>
<body>
    <div class="wrapper">
        <h1 class="title">@yield('title')</h1>

        @if( \Session::has('success_message') )
            <div class="container">
                <div class="row">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> {{ \Session::get('success_message') }}
                    </div>
                </div>
            </div>
        @endif

        @if( count($errors) > 0 )
            <div class="container">
                <div class="row">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </div><!-- zacky -->

    <div class="copyright text-center ">&copy; 2015 - Copyright By [VN]Zacky </div>

</body>
</html>