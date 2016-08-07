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
        <title>@yield('title', 'Home')</title>
        
        <link rel="stylesheet" href="/public/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/css/font-awesome.min.css">
        <link rel="stylesheet" href="/public/css/main.css">
        <link rel="stylesheet" href="/public/css/screen.css">
        
        <script src="/public/js/jquery.min.js"></script>
        
    </head>
    <body>
        <header>
            
        </header>
        
        <section id="main_body">
            <div class="container">
                @yield('content')
            </div>
        </section>
        
        <footer>
            
        </footer>
        
        <script src="/public/js/bootstrap.min.js"></script>
        <script src="/public/js/main.js"></script>
        
    </body>
</html>

