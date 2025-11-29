<x-layouts.app :title="__('Pagar')">
    <div class="p-6">
        <h1 class="text-2xl font-semibold mb-4">Checkout</h1>

        @if(empty($carrito))
            <div class="p-6 bg-white dark:bg-zinc-800 rounded shadow text-center">
                <p class="mb-4">No se encontró el carrito seleccionado.</p>
                <a href="{{ route('carrito.index') }}" class="inline-block px-4 py-2 rounded bg-indigo-600 text-white">Volver al carrito</a>
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 rounded shadow p-6">
                <h2 class="text-lg font-medium mb-2">Resumen del pedido #{{ $carrito->id }}</h2>
                <div class="mb-4">
                    <table class="w-full text-sm">
                        <thead class="text-zinc-600 text-left">
                            <tr>
                                <th class="pb-2">Producto</th>
                                <th class="pb-2">Cantidad</th>
                                <th class="pb-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carrito->stocks as $stock)
                                <tr class="border-t dark:border-zinc-700">
                                    <td class="py-3">{{ $stock->nombre_stock }}</td>
                                    <td class="py-3">{{ $stock->pivot->cantidad }}</td>
                                    <td class="py-3">${{ number_format($stock->pivot->precio * $stock->pivot->cantidad, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-zinc-500">Total</p>
                        <p class="text-2xl font-semibold">${{ number_format($carrito->total_precio, 2) }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <form action="{{ route('pago.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="carrito_id" value="{{ $carrito->id }}" />
                            <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white">Confirmar y Pagar</button>
                        </form>
                        <a href="{{ route('carrito.index') }}" class="px-4 py-2 rounded border">Volver</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
