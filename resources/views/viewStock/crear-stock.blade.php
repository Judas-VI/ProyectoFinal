<x-layaout class="fondo-landing overflow-auto">
    <x-navbar />

    <div class="d-flex justify-content-center align-items-start pt-5 min-vh-100 p-3 w-100 ">
        <div class="card p-4 shadow-lg col-11 col-sm-10 col-md-8 col-lg-7 col-xl-6">

            <h1 class="text-center mb-4">Nuevo Stock</h1>

            <form action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <label class="col-form-label text-md-end" for="precio">Precio:</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control form-control-lg @error('precio') is-invalid @enderror"
                            type="number"
                            name="precio"
                            id="precio"
                            step="0.01"
                            value="{{ old('precio') }}">
                        @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <label class="col-form-label text-md-end" for="nombre_stock">Nombre del producto:</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control form-control-lg @error('nombre_stock') is-invalid @enderror"
                            type="text"
                            name="nombre_stock" id="nombre_stock" value="{{ old('nombre_stock') }}">
                        @error('nombre_stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <label class="col-form-label text-md-end" for="fecha_creacion">Fecha de Creación:</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control form-control-lg @error('fecha_creacion') is-invalid @enderror"
                            type="date"
                            name="fecha_creacion" id="fecha_creacion" value="{{ old('fecha_creacion') }}">
                        @error('fecha_creacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control form-control-lg @error('stock') is-invalid @enderror" 
                        name="descripcion" 
                        id="descripcion" rows="4"> {{ old('descripcion') }} </textarea>
                        @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <label class="col-form-label text-md-end" for="stock">Stock:</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control form-control-lg @error('stock') is-invalid @enderror" 
                        type="number" name="stock" id="stock" value="{{ old('stock') }}">
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <div class="col-md-4">
                        <label class="col-form-label text-md-end" for="img">Imagen (Archivo):</label>
                    </div>
                    <div class="col-md-8">
                        <input class="form-control form-control-lg @error('img') is-invalid @enderror" 
                        type="file" name="img" id="img" accept="image/*" value="{{ old('img') }}">
                        @error('img')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary btn-lg" type="submit">Guardar Producto</button>
                </div>

            </form>
        </div>
    </div>
</x-layaout>