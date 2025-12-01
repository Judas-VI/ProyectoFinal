<x-layaout class="fondo-landing vh-100 overflow-hidden">
    <x-navbar/>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg border-0" style="max-width: 450px; width: 100%;">
            <div class="card-body p-4 p-md-5">
                <h1 class="text-center mb-4">Log in</h1>
                <form action="{{ route('usuario.login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Ingresar email</label>
                        <input
                            class="form-control @error('email') is-invalid @enderror"
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            maxlength="255" autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input
                            class="form-control @error('password') is-invalid @enderror"
                            type="password"
                            name="password"
                            id="password"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary btn-lg" type="submit">Iniciar Sesión</button>
                    </div>
                </form>

                <p class="text-center mt-3">
                    ¿No tienes cuenta? <a href="{{ route('usuario.create') }}">¡Regístrate aquí!</a>
                </p>

            </div>
        </div>
    </div>
</x-layout>
