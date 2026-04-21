<h2>Semua Produk</h2>

@foreach($products as $p)
    <div style="margin-bottom:20px;">
        <img src="{{ asset('storage/' . $p->image) }}" width="150">
        <p>{{ $p->name }}</p>
        <p>Rp {{ $p->price }}</p>
        <a href="/products/{{ $p->id }}">Detail</a>
    </div>
@endforeach