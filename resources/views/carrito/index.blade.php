<x-layaout class="fondo-usuario overflow-auto">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <x-navbar></x-navbar>
<div class="container py-4">

    <div class="d-flex justify-content-center mb-6">
        <div class="card w-50" style="max-width:600px;">
            <div class="card-body text-center py-2">
                <h1 class="h5 m-0"><i class="bi bi-cart"></i>Carrito de compras<i class="bi bi-cart"></i></h1>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
		<a href="{{ url('/menu') }}" class="btn btn-outline-secondary">eliminar carrito</a>
        
	</div>

	@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif

	@if(!empty($cartItems) && count($cartItems) > 0)
		<div class="table-responsive">
			<table class="table table-striped align-middle">
				<thead>
					<tr>
						<th>Producto</th>
						<th class="text-end">Precio</th>
						<th class="text-center">Cantidad</th>
						<th class="text-end">Subtotal</th>
						<th class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($cartItems as $item)
						<tr>
							<td>{{ $item->name ?? $item['name'] ?? 'Producto' }}</td>
							<td class="text-end">{{ number_format($item->price ?? $item['precio'] ?? 0, 2) }} €</td>
							<td class="text-center">{{ $item->quantity ?? $item['cantidad'] ?? 1 }}</td>
							<td class="text-end">
								{{ number_format( ($item->price ?? $item['price'] ?? $item['precio'] ?? 0) * ($item->quantity ?? $item['quantity'] ?? $item['cantidad'] ?? 1), 2) }} €
							</td>
							<td class="text-center">
								<form action="{{ route('cart.remove', $item->id ?? ($item['id'] ?? null)) }}" method="POST" style="display:inline;">
									@csrf
									@method('DELETE')
									<button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" class="text-end">Total</th>
						<th class="text-end">{{ number_format($total ?? 0, 2) }} €</th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="d-flex gap-2">
			<a href="{{ url('/menu') }}" class="btn btn-secondary">Regresar al menu</a>
			<a href="{{ route('checkout.index') }}" class="btn btn-primary">Ir a pagar</a>
		</div>
	@else
		<div class="card">
			<div class="card-body text-center">
				<p class="mb-3">Tu carrito está vacío.</p>
				<a href="{{ url('/bienvenida') }}" class="btn btn-primary">Ir al menú</a>
			</div>
		</div>
	@endif
</div>
<h1 class="text-center my-4">fuck da police bitches</h1>
<h2>El diablo anda suelto
Va pisando el mismo pavimento
Recorriendo el barrio por completo
Igual y me la fleto, si es que me lo topo
Como quiera, los dos estamos igual de locos</h2>
</x-layaout>