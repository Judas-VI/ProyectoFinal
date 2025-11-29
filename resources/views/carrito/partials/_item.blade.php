<tr class="border-t dark:border-zinc-700">
    <td class="py-3">
        <div class="flex items-center gap-3">
            @if(!empty($stock->img))
                <img src="{{ asset('Imagenes/'.$stock->img) }}" alt="{{ $stock->nombre_stock }}" class="h-12 w-12 object-cover rounded" />
            @endif
            <div>
                <div class="font-medium">{{ $stock->nombre_stock }}</div>
                <div class="text-xs text-zinc-500">{{ Str::limit($stock->descripcion, 80) }}</div>
            </div>
        </div>
    </td>
    <td class="py-3">${{ number_format($stock->pivot->precio, 2) }}</td>
    <td class="py-3">{{ $stock->pivot->cantidad }}</td>
    <td class="py-3">${{ number_format(($stock->pivot->precio * $stock->pivot->cantidad), 2) }}</td>
</tr>
