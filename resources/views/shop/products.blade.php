@extends('shop.layout')

@section('title', 'Sản phẩm')

@section('content')
<div class="flex flex-col md:flex-row gap-6">
    <aside class="md:w-64 w-full">
        <form method="get" action="{{ route('shop.products') }}" class="mb-6">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm sản phẩm..." class="w-full border rounded px-3 py-2">
        </form>
        <div class="card p-4">
            <div class="font-semibold mb-2">Danh mục</div>
            <ul class="space-y-2">
                <li><a class="{{ request('category') ? '' : 'chip-active' }} chip" href="{{ route('shop.products') }}">Tất cả</a></li>
                @foreach($categories as $cat)
                    @php($cSlug = is_array($cat) ? ($cat['slug'] ?? '') : ($cat->slug ?? ''))
                    @php($cName = is_array($cat) ? ($cat['name'] ?? '') : ($cat->name ?? ''))
                    <li>
                        <a class="chip {{ (request('category') === $cSlug) ? 'chip-active' : '' }}" href="{{ route('shop.products', ['category' => $cSlug] + request()->except('page')) }}">{{ $cName }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    <section class="flex-1">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="card p-3 flex flex-col">
                    <a href="{{ route('shop.product', $product['slug'] ?? $product->slug) }}">
                        <img class="w-full h-56 md:h-48 object-cover rounded-lg mb-3" src="{{ $product['main_image'] ?? ($product->main_image ?? '') }}" alt="{{ $product['name'] ?? $product->name }}">
                        <div class="font-semibold">{{ $product['name'] ?? $product->name }}</div>
                    </a>
                    <div class="price mt-1">
                        {{ ($product['formatted_sale_price'] ?? null) ?: ($product['formatted_price'] ?? $product->formatted_price ?? '') }}
                    </div>
                    <form action="{{ route('cart.add', $product['id'] ?? $product->id ?? 1) }}" method="post" class="mt-auto pt-3">
                        @csrf
                        <button class="btn btn-primary">Thêm vào giỏ</button>
                    </form>
                </div>
            @empty
                <p>Không có sản phẩm phù hợp.</p>
            @endforelse
        </div>
        
    </section>
</div>
@endsection


