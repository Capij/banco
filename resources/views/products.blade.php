@extends('layout')

@section('content')
    <h1 class="page-header">Listado de productos</h1>
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Stock</th>
            </tr>                            
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td class="text-right">{{ $product->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <hr>
    <p>
        <a href="{{ route('products.pdf') }}" class="btn btn-sm btn-primary">
            Descargar productos en PDF
        </a>
    </p>
@endsection