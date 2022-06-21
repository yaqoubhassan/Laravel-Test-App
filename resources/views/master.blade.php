<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Test App</title>

    {{-- <link rel="stylesheet" href="/css/app.css"> --}}
    <link rel="stylesheet" href="/css/style.css">

    <style>
      #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        width: 100vw;
        height: 100vh;
        display: flex;
      }
      
      #app aside {
        width: 300px;
        height: 100vh;
        background: #fff;
      }
      #app aside h1 {
        text-align: center;
      }
      
      #app main {
        flex-grow: 1;
        height: 100vh;
      }
      
      ul {
        list-style: none;
        padding: 0;
        width: 100%;
        margin-top: 100px;
      }
      ul > li {
        display: block;
      }
      ul > li > a {
        display: block;
        padding: 15px 25px;
        width: 100%;
      }
      
      ul > li > a:hover {
        background: rgba(66, 185, 131, 0.2);
      }
      
      nav a.active {
        color: var(--main-color);
        border-right: 4px solid var(--main-color);
        background: rgba(66, 185, 131, 0.2);
      }
      
      main {
        overflow-y: auto;
        padding: 50px 100px;
      }
    </style>

  </head>
  <body>
    <div id="app">
      <aside>
        <br />
        <h1>Test App</h1>
        <br />
  
        <nav>
          <ul>
            <li>
              <router-link to="/" :class="{ active: $route.path === '/' }">
                Home
              </router-link>
            </li>
            <li>
              <router-link to="/admin" :class="{ active: $route.path === '/admin' }">
                Admin
              </router-link>
            </li>
          </ul>
        </nav>
      </aside>

      <main>
        <router-view></router-view>
      </main>
        
    </div>
    
      
      <script src="/js/app.js"></script>
  </body>
</html>
