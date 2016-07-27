<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=divice-width, initial-scale=1">
        <title>@yield('title', 'Manage')</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/adminsrc/css/main.css">

        <script src="/js/jquery.min.js"></script>
        <script>
            var _token = '<?php echo csrf_token(); ?>';
        </script>
        @yield('head')
    </head>
    <body @yield('ngApp', '')>
        <header>
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-menu" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand text-uppercase" href="#">Admin panel</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-menu">
                        <ul class="nav navbar-nav navbar-right">
                            @foreach(get_langs() as $lang)
                            <li><a href="{{$lang->switch_url()}}">{!! $lang->icon() !!} {{$lang->name}}</a></li>
                            @endforeach
                            
                            @if(auth()->check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell-o"></i> <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#">Separated link</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{auth()->user()->name}} <i class="fa fa-caret-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('logout')}}"><i class="fa fa-power-off"></i> {{trans('auth.logout')}}</a></li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>

        <section id="main_body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-3 col-sm-2 menu_col">
                        @include('manage.parts.menubar')
                    </div>
                    <div class="col-xs-9 col-sm-10 content_col">
                        <h2 class="page-header">@yield('page_title', 'Manage')</h2>
                        @yield('table_nav')
                        <div class="page_content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="text-center">Designed by Pinla</div>
        </footer>

        <script src="/js/bootstrap.min.js"></script>
        <script src="/adminsrc/js/main.js"></script>
        
        @yield('foot')
    </body>
</html>
