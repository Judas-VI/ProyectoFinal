<x-layaout class="fondo-usuario vh-100 overflow-hidden">
    <x-navbar />

    <div class="container pt-5 pb-5"> 
        
        <div class="row justify-content-center"> 
            
            <div class="col-12 col-md-8 col-lg-6"> 

                <div class="card h-100 shadow-lg border-0">

                    <img src="{{ asset('storage/' . $stock->img) }}" 
                         class="card-img-top" 
                         alt="Imagen de {{ $stock->nombre_stock }}" 
                         style="height: 300px; object-fit: cover;"> <div class="card-body d-flex flex-column">

                        <h5 class="card-title text-truncate">{{ $stock->nombre_stock }}</h5>

                        <h4 class="text-primary mb-3">
                            ${{ number_format($stock->precio, 2, ',', '.') }}
                        </h4>

                        <p class="card-text text-muted flex-grow-1">
                            {{ $stock->descripcion }}
                        </p>

                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                **Stock Disponible:**
                                <span class="badge {{ $stock->stock > 10 ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill">
                                    {{ $stock->stock }}
                                </span>
                            </li>
                            <li class="list-group-item">
                                <small class="text-muted">Creado: {{ $stock->fecha_creacion }}</small>
                            </li>
                        </ul>
                        <div class="mt-3 d-flex">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                &larr; Regresar al stock
                            </a>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-layaout>