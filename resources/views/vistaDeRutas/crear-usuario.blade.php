<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar</title>
</head>
<body>
    <h1>¡Bienvenido!</h1>
    <form action="{{ route('usuario.store') }}" method="POST">
        @csrf
            <label class="form-label" for="nombre">Nombre:</label>
            <input
                class="form-control"
                type="text"
                id="nombre"
                name="nombre"
                >
            @error('nombre')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label class="form-label" for="apellido">Apellido:</label>
            <input 
                class="form-control"
                type="text"  
                id="apellido" 
                name="apellido"
                >
            @error('apellido')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label for="email">Ingresar email</label>
            <input 
                class="form-control"
                type="email"  
                id="email" 
                name="email"
                 >
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <label for="password">Contraseña</label>
            <input 
                class="form-control"
                type="password" 
                name="password" 
                id="password" >
        <br>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>