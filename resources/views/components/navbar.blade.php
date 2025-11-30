<div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container">
            <!--Logo-->
            <img src="{{ asset('Imagenes/logo.png') }}" width="60px" alt="Logo">
            <a class="navbar-brand fs-4 bg-black" href="{{ route('bienvenida') }}">CondonPlex.</a>
            <!-- Toggle -->
            <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--sideBar-->
            <div class="sidebar offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header text-white border-bottom">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                    <button type="button" class="btn-close btn-close-whithe" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li>    
                            <a class="nav-link" href="/carrito"><i class="bi bi-cart"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('bienvenida') }}">Inicio</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#service">Service</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>

                    </ul>
                    <!--Login-->
                    <div class="d-flex flex-colum  justify-content-center aling-items-center gap-3">
                        <a href="{{ route('usuario-login-vista') }}" class="text-white text-decoration-none px-3 py-1 rounded-4"
                            style="background-color: #c84cf9;">Login</a>
                        <a href=" {{ route('usuario.create') }} "
                            class="text-white text-decoration-none px-3 py-1 rounded-4"
                            style="background-color: #f94ca4;">Sing-Up</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>