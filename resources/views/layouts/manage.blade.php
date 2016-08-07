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

        <link rel="stylesheet" href="/adminsrc/css/select2.min.css">
        <link rel="stylesheet" href="/adminsrc/css/nested_menu.css">
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/adminsrc/css/main.css">

        <script src="/js/jquery.min.js"></script>
        <script>
            var _token = '<?php echo csrf_token(); ?>';
        </script>
        @yield('head')
    </head>
    <body @yield('bodyAttrs', '')>
           <section id="main_body">
                <div class="menu_col">
                    <nav class="navbar navbar-default menu-brand">
                        <div class="navbar-header text-center">
                            <a class="navbar-brand text-uppercase" href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> <span>Admin panel</span></a>
                        </div>
                    </nav>
                    @include('manage.parts.menubar')
                </div>
                <div class="content_col">
                    <nav class="navbar navbar-default" id="head_bar">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-menu" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand toggle_menu_bar" href="#"><i class="fa fa-bars"></i></a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-menu">
                            <form class="navbar-form navbar-left head_search_form search_form">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="key" value="" class="form-control" placeholder="{{trans('manage.search')}}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                            <ul class="nav navbar-nav navbar-right">
                                @if(auth()->check())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell-o"></i> <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu user_notify">
                                        <li><a href="#">Action</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> {{auth()->user()->name}} <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('mn.profile')}}"><i class="fa fa-user"></i> {{trans('auth.account_info')}}</a></li>
                                        <li><a href="{{route('logout')}}"><i class="fa fa-power-off"></i> {{trans('auth.logout')}}</a></li>
                                    </ul>
                                </li>
                                @endif
                            </ul>
                            <ul class="langs_nav nav navbar-nav navbar-right">
                                @foreach(get_langs() as $lang)
                                <li><a href="{{$lang->switch_url()}}">{!! $lang->icon() !!} {{$lang->name}}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </nav>
                    
                    <div class="main_content">
                        <h2 class="page-header">@yield('page_title', 'Manage')</h2>
                        @yield('table_nav')
                        <div class="page_content">
                                @yield('content')
                        </div>
                    </div>
                </div>
        </section>

        <footer>
            <div class="text-center">Designed by Pinla</div>
        </footer>

        <script src="/adminsrc/js/select2.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/adminsrc/js/main.js"></script>

        @yield('foot')
    </body>
</html>
