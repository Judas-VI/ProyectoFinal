<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket</title>
    <style>
        /* Ticket-friendly styles */
        @page { margin: 5mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #000; }
        .ticket { width: 320px; margin: 0 auto; }
        .center { text-align: center; }
        .small { font-size: 11px; }
        .muted { color: #555; }
        h2 { margin: 0 0 6px 0; font-size: 16px; }
        .meta { margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 4px 0; }
        .qty { width: 18%; text-align: center; }
        .price { width: 30%; text-align: right; }
        .name { width: 52%; }
        .total { border-top: 1px dashed #000; padding-top: 6px; font-weight: bold; }
        .footer { margin-top: 10px; border-top: 1px dashed #000; padding-top: 6px; font-size: 11px; }
    </style>
</head>
<body>
<div class="ticket">
    <div class="center">
        <h2>{{ $storeName ?? 'Mi Tienda' }}</h2>
        <div class="small muted">{{ $storeAddress ?? 'Calle Falsa 123, Ciudad' }}</div>
    </div>

    <div class="meta small">
        <div>Fecha: {{ $date ?? date('d/m/Y H:i') }}</div>
        <div>Orden: {{ $orderId ?? '0001' }}</div>
    </div>

    @php
        $items = $items ?? [
            ['name' => 'Producto A', 'qty' => 1, 'price' => 150.00],
            ['name' => 'Producto B', 'qty' => 2, 'price' => 45.50],
            ['name' => 'Producto C', 'qty' => 1, 'price' => 9.99],
        ];
        $total = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th class="name">Producto</th>
                <th class="qty">Cant.</th>
                <th class="price">Precio</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $it)
            @php $line = $it['qty'] * $it['price']; $total += $line; @endphp
            <tr>
                <td class="name">{{ 
                    strlen($it['name']) > 30 ? substr($it['name'],0,27) . '...' : $it['name']
                }}</td>
                <td class="qty">{{ $it['qty'] }}</td>
                <td class="price">{{ number_format($it['price'], 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="total small">
        <div style="display:flex; justify-content:space-between;">
            <div>Subtotal</div>
            <div>{{ number_format($total, 2, ',', '.') }}</div>
        </div>
        @php $tax = $tax ?? 0; $grand = $total + $tax; @endphp
        <div style="display:flex; justify-content:space-between;">
            <div>IVA</div>
            <div>{{ number_format($tax, 2, ',', '.') }}</div>
        </div>
        <div style="display:flex; justify-content:space-between; font-weight:bold; margin-top:6px;">
            <div>Total</div>
            <div>{{ number_format($grand, 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="footer center small muted">
        Gracias por su compra
        <div>Tel: {{ $storePhone ?? '0000-0000' }}</div>
    </div>
</div>
</body>

</body>
</html>
