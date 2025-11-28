<x-layaout class="fondo-usuario overflow-auto">
    <x-navbar/>
    <div class="d-flex justify-content-center align-items-start pt-5 min-vh-100 p-3 w-100 ">

        <div class="card p-4 shadow-lg col-11 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            <h1 class="text-center mb-4">¡Bienvenido!</h1>

            <form action="{{ route('usuario.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre:</label>
                    <input class="form-control form-control-lg @error('nombre') is-invalid @enderror"
                           type="text" id="nombre" name="nombre" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="apellido">Apellido:</label>
                    <input class="form-control form-control-lg @error('apellido') is-invalid @enderror"
                           type="text" id="apellido" name="apellido" value="{{ old('apellido') }}">
                    @error('apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Ingresar email:</label>
                    <input class="form-control form-control-lg @error('email') is-invalid @enderror"
                           type="email" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password">Contraseña:</label>
                    <input class="form-control form-control-lg @error('password') is-invalid @enderror"
                           type="password" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary btn-lg" type="submit">Guardar</button>
                </div>

            </form>
        </div>
    </div>

</x-layaout>
