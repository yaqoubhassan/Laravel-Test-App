<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test App | @yield('title')</title>

        <link rel="stylesheet" href="/css/app.css">

        <style>
            body {
              margin: 0;
              font-family: "Lato", sans-serif;
            }
            
            .sidebar {
              margin: 0;
              padding: 0;
              width: 200px;
              background-color: #f1f1f1;
              position: fixed;
              height: 100%;
              overflow: auto;
            }
            
            .sidebar a {
              display: block;
              color: black;
              padding: 16px;
              text-decoration: none;
            }
             
            .sidebar a.active {
              background-color: #0A58CA;
              color: white;
            }
            
            .sidebar a:hover:not(.active) {
              background-color: rgb(155, 198, 247);
              color: white;
            }
            
            div.content {
              margin-left: 200px;
              padding: 1px 16px;
              height: 1000px;
            }
            
            @media screen and (max-width: 700px) {
              .sidebar {
                width: 100%;
                height: auto;
                position: relative;
              }
              .sidebar a {float: left;}
              div.content {margin-left: 0;}
            }
            
            @media screen and (max-width: 400px) {
              .sidebar a {
                text-align: center;
                float: none;
              }
            }
        </style>

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-lg bg-light">
                <div class="container-fluid">
                  <a class="navbar-brand" href="#">Test App</a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                </div>
            </nav>
            <div class="sidebar">
                <a class="active" href="#home">PDF Files</a>
                <a href="#news">HTML Snippets</a>
                <a href="#contact">Links</a>
            </div>
            
            <div class="content">
                @yield('content')
            </div>
            

        </div>
        
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>

