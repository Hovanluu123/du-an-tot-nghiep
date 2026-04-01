@extends('shop.layout')

@section('title', ($product->name ?? $product['name'] ?? 'Sản phẩm'))

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div>
        @php($images = $product->images ?? ($product['images'] ?? []))
        @if(!empty($images))
            <img class="w-full rounded border object-cover" style="max-height: 480px" src="{{ $images[0] }}" alt="{{ $product->name ?? $product['name'] }}">
            @if(count($images) > 1)
                <div class="grid grid-cols-4 gap-2 mt-2">
                    @foreach($images as $img)
                        <img class="w-full h-20 object-cover rounded border" src="{{ $img }}" alt="thumb">
                    @endforeach
                </div>
            @endif
        @endif
    </div>
    <div>
        <h1 class="text-2xl font-bold mb-2">{{ $product->name ?? $product['name'] }}</h1>
        <div class="mb-2 text-gray-500">Mã SKU: {{ $product->sku ?? $product['sku'] ?? 'PRD-XXXX' }}</div>
        <div class="text-2xl text-red-600 font-bold mb-4">{{ ($product->formatted_sale_price ?? $product['formatted_sale_price'] ?? null) ?: ($product->formatted_price ?? $product['formatted_price'] ?? '') }}</div>
        <p class="prose max-w-none mb-6">{{ $product->description ?? $product['description'] }}</p>

        <form action="{{ route('cart.add', $product->id ?? $product['id'] ?? 1) }}" method="post" class="flex items-center gap-2">
            @csrf
            <input class="w-24 border rounded px-3 py-2" type="number" name="quantity" value="1" min="1">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Thêm vào giỏ</button>
        </form>
    </div>
</div>

@if($relatedProducts->count())
    <h2 class="text-xl font-semibold mt-10 mb-4">Sản phẩm liên quan</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @foreach($relatedProducts as $p)
            <div class="border rounded p-3 bg-white">
                <a href="{{ route('shop.product', $p->slug) }}">
                    @if($p->main_image)
                        <img class="w-full h-40 object-cover mb-2" src="{{ $p->main_image }}" alt="{{ $p->name }}">
                    @endif
                    <div class="font-semibold">{{ $p->name }}</div>
                </a>
                <div class="text-red-600 font-bold">{{ $p->formatted_sale_price ?? $p->formatted_price }}</div>
            </div>
        @endforeach
    </div>
@endif
@endsection


