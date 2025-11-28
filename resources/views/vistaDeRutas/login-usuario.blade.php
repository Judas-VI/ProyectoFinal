<x-layout>
    <h1>Log in</h1>
    <form action="{{ route('usuario.login') }}" method="POST">
        @csrf
            <label for="email">Ingresar email</label>
            <input 
                class="form-control"
                type="email"  
                id="email" 
                name="email"
                required>

            <label for="password">Contraseña</label>
            <input 
                class="form-control"
                type="password" 
                name="password" 
                id="password">
        <br>
        <button type="submit">Guardar</button>
    </form> <br>
    <p>¿No tienes cuenta? <a href="{{ route('usuario.create') }}">¡Registrate aqui!</a> </p>
</x-layout>