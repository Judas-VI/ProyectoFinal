<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<!-- data-bs-theme="dark" -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('Styles/style.css') }}">

  <title>CondonPlex | Welcome</title>
</head>

<body class="vh-100 overflow-hidden">

  <!-- Navbarr-->
<nav class="navbar navbar-expand-lg bg-black">
  <div class="container">
    <!--Logo-->
    <img src="{{ asset('Imagenes/logo.png') }}" width="60px" alt="Logo">
    <a class="navbar-brand fs-4 bg-black" href="#">CondonPlex.</a>
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
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
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
          <a href="login" class="text-white text-decoration-none px-3 py-1 rounded-4"
          style="background-color: #c84cf9;">Login</a>
          <a href="SingUp" 
          class="text-white text-decoration-none px-3 py-1 rounded-4"
          style="background-color: #f94ca4;">Sing-Up</a>
        </div>
      </div>
    </div>
  </div>
</nav>


<main>
  <section class="w-100 vh-100 d-flex flex-column justify-content-center align-items-center text-white fs-1">
    <h1 style="font-size: 1.5em">Me quiero</h1>
    <h1 style="font-size: 1.3em">Matar</h1>
</section>
</main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>