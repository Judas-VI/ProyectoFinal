<x-layaout class="fondo-usuario overflow-auto">
    <x-navbar/>
    <h1>Log in</h1>
    <form action="{{ route('usuario.login') }}" method="POST">
        @csrf
            <label for="email">Ingresar email</label>
            <input 
                class="form-control"
                type="email"  
                id="email" 
                name="email"
                value="{{ old('email') }}"
                required maxlength="255" autocomplete="email">
            @error('email')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <label for="password">Contraseña</label>
            <input 
                class="form-control"
                type="password" 
                name="password" 
                id="password"
                    required>
            @error('password')
                <p class="text-danger">{{$message}}</p>
            @enderror
        <br>
        <button type="submit">Guardar</button>
    </form> <br>
    <p>¿No tienes cuenta? <a href="{{ route('usuario.create') }}">¡Registrate aqui!</a> </p>
</x-layout>
