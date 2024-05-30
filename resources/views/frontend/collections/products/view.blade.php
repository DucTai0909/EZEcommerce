@extends('layouts.app')
@section('title', $product->name)

@section('content')

    <div>
        <livewire:frontend.product.view :category="$category" :product="$product" />
    </div>
@endsection