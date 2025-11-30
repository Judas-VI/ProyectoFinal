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
</html>
En eso ahí yo llego y me prendo un gran leño
En lo que me alucino siento que estoy en un sueño
Mi mente se vacía en lo que llego a la esquina
Me meto a la tienda pa' pedir unas pastillas
Le digo al tendero mejor sácame el dinero
Si no me haces caso de seguro aquí te enfierro
Se la anda de guerrero en lo que yo forcejeo
Le doy tres puñaladas al pinche anciano culero
Abro la caja fuerte y tomo todo lo que puedo
Sabía que los vecinos ya estaban poniendo dedo
No corrí ni tres cuadras cuando una pixelieada
Me para y entre los guachos me agarran a patadas
Ahora estoy en prisión y ya no recuerdo nada
Lo último que escuche fue
Chido, camarada
El diablo anda suelto
Va pisando el mismo pavimento
Recorriendo el barrio por completo
Igual y me la fleto, si es que me lo topo
Como quiera, los dos estamos igual de locos
El diablo anda suelto
Va pisando el mismo pavimento
Recorriendo el barrio por completo
Igual y me la fleto, si es que me lo topo
Como quiera, los dos estamos igual de locos</h3>
    <p>Este PDF fue generado con Laravel.</p>
</body>
</html>
