<?php
$GLOBALS['bower_components_path'] = asset('bower_components') . '/';
$GLOBALS['img_path'] = asset('img') . '/';
$GLOBALS['app_js'] = asset('script/AuthenticatedUser') . '/';

function set_css($css_array) {

    $count_css = count($css_array);
    $set_css_str = '';
    for ($i = 0; $i < $count_css; $i++) {
        $set_css_str .= '<link href="' . $GLOBALS['bower_components_path'] . $css_array[$i] . '" rel="stylesheet">' . "\n";
    }
    return $set_css_str;
}

function set_js($js_array) {

    $count_js = count($js_array);
    $set_js_str = '';
    for ($i = 0; $i < $count_js; $i++) {
        $set_js_str .= '<script src="' . $GLOBALS['bower_components_path'] . $js_array[$i] . '"></script>' . "\n";
    }
    return $set_js_str;
}

function set_app_js($js_array) {

    $count_js = count($js_array);
    $set_js_str = '';
    for ($i = 0; $i < $count_js; $i++) {
        $set_js_str .= '<script src="' . $GLOBALS['app_js'] . $js_array[$i] . '"></script>' . "\n";
    }
    return $set_js_str;
}
?>

<?php
//echo '<pre>';
//print_r(session('instituteDetails'));
//echo session('instituteDetails')->school_branch_name;
//echo '</pre>';
//exit();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $data['pageTitle'] or '&nbsp;' }}</title>

        <?php
        $css_array = array(
            'bootstrap/dist/css/bootstrap.min.css',
            'font-awesome/css/font-awesome.min.css',
            'bootstrap/dist/css/jquery-ui.css'
        );
        echo set_css($css_array);
        ?>

        <style type="text/css">
            body{
                background: #F5F8FA;
            }
            .navbar{
                border-radius: 0;
            }
            .navbar-brand{
                padding: 0;
            }
            .vertical-center {
                min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
                min-height: 100vh; /* These two lines are counted as one :-)       */
                display: flex;
                align-items: center;
            }
            .breadcrumb{
                background-color: transparent;
            }
            .panel{
                border-radius: 0;
            }
            .btn{
                font-weight: bold;
                border-radius: 0;
            }
            .form-group-sm .form-control{
                border-radius: 0;
            }
            .alert{
                border-radius: 0;
            }
            .list-group-item:first-child, .list-group-item:last-child{
                border-radius: 0;
            }
            .list-group-item {
                padding: 4px 10px
            }
            .btn-breadcrumb .btn:not(:last-child):after {
                content: " ";
                display: block;
                width: 0;
                height: 0;
                border-top: 17px solid transparent;
                border-bottom: 17px solid transparent;
                border-left: 10px solid white;
                position: absolute;
                top: 50%;
                margin-top: -17px;
                left: 100%;
                z-index: 3;
            }
            .btn-breadcrumb .btn:not(:last-child):before {
                content: " ";
                display: block;
                width: 0;
                height: 0;
                border-top: 17px solid transparent;
                border-bottom: 17px solid transparent;
                border-left: 10px solid rgb(173, 173, 173);
                position: absolute;
                top: 50%;
                margin-top: -17px;
                margin-left: 1px;
                left: 100%;
                z-index: 3;
            }

            /** The Spacing **/
            .btn-breadcrumb .btn {
                padding:3px 12px 6px 24px;
            }
            .btn-breadcrumb .btn:first-child {
                padding:5px 6px 4px 10px;
            }
            .btn-breadcrumb .btn:last-child {
                padding:5px 18px 4px 24px;
            }

            /** Default button **/
            .btn-breadcrumb .btn.btn-default:not(:last-child):after {
                border-left: 10px solid #fff;
            }
            .btn-breadcrumb .btn.btn-default:not(:last-child):before {
                border-left: 10px solid #ccc;
            }
            .btn-breadcrumb .btn.btn-default:hover:not(:last-child):after {
                border-left: 10px solid #ebebeb;
            }
            .btn-breadcrumb .btn.btn-default:hover:not(:last-child):before {
                border-left: 10px solid #adadad;
            }
            .panel-heading{
                padding: 5px 15px;
            }
            sup{
                color: red;
            }
            .form-horizontal .control-label {
                text-align: left;
            }
            .vertical-center {
                min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
                min-height: 100vh; /* These two lines are counted as one :-)       */

                display: flex;
                align-items: center;
            }
        </style>

        <script>
            var baseURL = '{{ url("/") }}' + '/';
        </script>

    </head>
    <body>

        @if(Auth::check())
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ $GLOBALS['img_path'] }}school_logo_1.png" width="50">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            @if(Auth::user()->role_id == 9)
                            <strong>
                                {{ Auth::check() ? (session()->has('instituteDetails') ? session('instituteDetails')->institute_name : '') : '' }}
                            </strong>
                            <br>{{ Auth::check() ? (session()->has('instituteDetails') ? session('instituteDetails')->bank_name : '') : '' }}
                            ({{ Auth::check() ? (session()->has('instituteDetails') ? session('instituteDetails')->branch_name : '') : '' }})
                            @else
                            <strong>
                                {{ Auth::check() ? (session()->has('instituteDetails') ? session('instituteDetails')->institute_name : '') : '' }}
                            </strong>
                            <br>{{ Auth::check() ? (session()->has('instituteDetails') ? session('instituteDetails')->school_branch_name : '') : '' }}
                            ({{ Auth::check() ? (session()->has('instituteDetails') ? session('instituteDetails')->school_version_name : '') : '' }} Version)
                            @endif
                        </li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a><kbd>{{ Auth::check() ? (session()->has('roleName') ? session('roleName') : 'Unknown') : 'Guest' }}</kbd></a></li>
                        @if(Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <strong>{{ Auth::user()->full_name  }}</strong> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url(route('home::signOut')) }}"><i class="fa fa-power-off"></i> Sign Out</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav> 
        @endif

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-2">
                    @if(Auth::check())
                    @include('AuthenticatedUser.parentMenuListLeft')
                    @endif
                </div>

                <div class="col-sm-8">
                    @if(Auth::check())
                    @if(isset($data['brdcrmb']))
                    {!! Breadcrumbs::render('custom', $data['brdcrmb']) !!}
                    @endif
                    @endif
                    
                    @yield('main_content')
                </div>

                <div class="col-sm-2">
                    @if(Auth::check())
                    @include('AuthenticatedUser.parentMenuListRight')
                    @endif
                </div>
            </div>
        </div>


        <?php
        $js_array = array(
            'jquery/dist/jquery.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'jquery/dist/jquery-1.12.4.js',
            'jquery/dist/jquery-ui.js'
        );
        echo set_js($js_array);

        if (isset($data['jsArray'])) {
            $js_array = array();
            for ($i = 0; $i < count($data['jsArray']); $i++) {
                array_push($js_array, $data['jsArray'][$i]);
            }
            echo set_app_js($js_array);
        }
        ?>


        <script>
            $(function () {
                $(document).find('form').closest('div').before('<div class="form-group form-group-sm"><p class="col-sm-12">Fields mark with(<sup><i class="fa fa-asterisk"></i></sup>) are mandatory.</p></div>');
            });
            $(document).ajaxStart(function () {
                $("#wait").css("display", "block");
            });
            $(document).ajaxComplete(function () {
                $("#wait").css("display", "none");
            });
            $(function () {
                $("#check_date, #dateOf, #from_date, #to_date").datepicker({
					dateFormat: "dd-mm-yy"
                   // changeMonth: true,
                   // changeYear: true
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


            });
        </script>
    </body>
</html>