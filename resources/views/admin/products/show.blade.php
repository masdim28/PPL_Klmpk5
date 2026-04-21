<h2>Detail Produk</h2>

<p><strong>Nama:</strong> {{ $product->name }}</p>
<p><strong>Deskripsi:</strong> {{ $product->description }}</p>
<p><strong>Harga:</strong> {{ $product->price }}</p>
<p><strong>Stok:</strong> {{ $product->stock }}</p>
<p><strong>Kategori:</strong> {{ $product->category->name }}</p>
<p><strong>Status:</strong> {{ $product->status }}</p>

<img src="{{ asset('storage/' . $product->image) }}" width="200">

<br><br>
<a href="{{ route('products.index') }}">Kembali</a>