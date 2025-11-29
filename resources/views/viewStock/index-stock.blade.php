<x-layaout class="fondo-landing">
    <x-navbar />

    <div class="container pt-5 pb-5">
        <h1 class="text-center mb-5">Inventario de Stock</h1>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($stocks as $stock)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        
                        <img src="{{ asset('storage/' . $stock->img) }}" class="card-img-top" alt="Imagen de {{ $stock->nombre_stock }}"  style="height: 200px; object-fit: cover;"> 

                        <div class="card-body d-flex flex-column">
                            
                            <h5 class="card-title text-truncate">{{ $stock->nombre_stock }}</h5>
                            
                            <h4 class="text-primary mb-3">
                                ${{ number_format($stock->precio, 2, ',', '.') }}
                            </h4>
                            
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($stock->descripcion, 15) }}...<br>
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
                            
                            <div class="mt-auto d-grid">
                                <a href="{{ route('stock.show', $stock->id) }}" class="btn btn-dark">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        
        @unless (count($stocks))
            <p class="d-flex justify-content-center align-items-start pt-5 min-vh-100 p-3">Aún no hay productos en stock. 
            </p>
        @endunless

    </div>
</x-layaout>