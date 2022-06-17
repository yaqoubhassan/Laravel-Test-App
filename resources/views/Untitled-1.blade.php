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
