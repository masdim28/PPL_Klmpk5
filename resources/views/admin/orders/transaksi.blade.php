<h2>Data Pesanan</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Total</th>
    <th>Pembayaran</th>
    <th>Status</th>
    <th>Produk</th>
    <th>Aksi</th>
</tr>

@foreach($orders as $order)
<tr>
    <td>{{ $order->id }}</td>
    <td>Rp {{ $order->total_price }}</td>
    <td>{{ $order->payment_method }}</td>
    <td>{{ $order->status }}</td>
    <td>
        @foreach($order->items as $item)
            {{ $item->product->name }} ({{ $item->qty }})<br>
        @endforeach
    </td>
    <td>
        <a href="/admin/orders/{{ $order->id }}/status">
            Update Status
        </a>
    </td>
</tr>
@endforeach

</table>