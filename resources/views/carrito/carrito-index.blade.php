<x-layaout class="fondo-usuario overflow-auto">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
	<x-navbar></x-navbar>
	<div class="container py-4">

		<div class="d-flex justify-content-center mb-4">
			<div class="card w-60" style="max-width:600px;">
			<div class="card-body text-center py-4g">
			<h1 class="h5 m-0"><i class="bi bi-cart"></i>Carrito de compras<i class="bi bi-cart"></i></h1>
			</div>
			</div>
		</div>

		<div class="d-flex justify-content-between align-items-center mb-4">
			@php $primerCarrito = $carritos->first(); @endphp
			@if(!empty($primerCarrito))
			<form action="{{ route('carrito.destroy', $primerCarrito->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este carrito y todos sus productos?');">
				@csrf
				@method('DELETE')
				<button class="btn btn-outline-danger">Eliminar carrito</button>
			</form>
			@else
			<a href="{{ url('/#') }}" class="btn btn-outline-secondary">Volver al menú</a>
			@endif
		</div>

		@if(session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
		@endif

		@php
			$articulosSesion = session('guest_carrito', []);
		@endphp

		@if(!empty($carritos) && $carritos->count() > 0)
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
				<!-- para calcular el total es necesario hacerlo en el controller, pero usando eso jala -->
					@php $total = 0; @endphp
					@foreach($carritos as $carrito)
					@foreach($carrito->stocks as $stock)
					@php
					$precio = $stock->pivot->precio ?? 0;
					$cantidad = $stock->pivot->cantidad ?? 1;
					$subtotal = $precio * $cantidad;
					$total += $subtotal;
					@endphp
					<tr>
						<td>{{ $stock->nombre_stock ?? 'Producto' }}</td>
						<td class="text-end">{{ number_format($precio, 2) }} $</td>
						<td class="text-center">{{ $cantidad }}</td>
						<td class="text-end">{{ number_format($subtotal, 2) }} $</td>
						<td class="text-center">
							<form action="{{ route('pivote_stock_carrito.destroy', $stock->pivot->id ?? null) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto del carrito?');" style="display:inline;">
								@csrf
								@method('DELETE')
								<button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
							</form>
						</td>
					</tr>
					@endforeach
					@endforeach
				</tbody>
				<tfoot>
					<tr>
					<th colspan="3" class="text-end">Total</th>
					<th class="text-end">{{ number_format($total ?? 0, 2) }} $</th>
					<th></th>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="d-flex gap-2">
			<a href="{{ url('/#') }}" class="btn btn-secondary">Regresar al menú</a>
			@php $primerCarrito = $carritos->first(); @endphp
			<a href="{{ route('carrito.show', $primerCarrito->id) }}" title="{{ route('carrito.show', $primerCarrito->id) }}" class="btn btn-primary">Ir a pagar</a>
		</div>
		@elseif(!empty($articulosSesion) && count($articulosSesion) > 0)
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
						@php
							$ids = collect($articulosSesion)->pluck('stock_id')->all();
							$stocks = \App\Models\Stock::whereIn('id', $ids)->get()->keyBy('id');
							$total = 0;
						@endphp
						@foreach($articulosSesion as $item)
							@php
								$stock = $stocks[$item['stock_id']] ?? null;
								$precio = $item['precio'] ?? ($stock->precio ?? 0);
								$cantidad = $item['cantidad'] ?? 1;
								$subtotal = $precio * $cantidad;
								$total += $subtotal;
							@endphp
							<tr>
								<td>{{ $stock->nombre_stock ?? 'Producto' }}</td>
								<td class="text-end">{{ number_format($precio, 2) }} $</td>
								<td class="text-center">{{ $cantidad }}</td>
								<td class="text-end">{{ number_format($subtotal, 2) }} $</td>
								<td class="text-center">
									<form action="{{ route('carrito.guest.remove') }}" method="POST" onsubmit="return confirm('¿Eliminar este producto del carrito?');" style="display:inline;">
										@csrf
										<input type="hidden" name="stock_id" value="{{ $item['stock_id'] }}">
										<button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
									</form>
								</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
						<th colspan="3" class="text-end">Total</th>
						<th class="text-end">{{ number_format($total ?? 0, 2) }} $</th>
						<th></th>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="d-flex gap-2">
				<a href="{{ url('/') }}" class="btn btn-secondary">Regresar al stock</a>
				<a href="{{ route('pago.generar.pdf') }}" title="{{ route('pago.generar.pdf') }}" class="btn btn-primary">Ir a pagar</a>
			</div>
		@else
			<div class="card">
				<div class="card-body text-center">
				<p class="mb-3">Tu carrito está vacío.</p>
				<a href="{{ url('/#') }}" class="btn btn-primary">Ir al menú</a>
				</div>
			</div>
		@endif
	</div>
</x-layaout>