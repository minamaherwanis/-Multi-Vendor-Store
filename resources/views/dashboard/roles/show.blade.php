@extends('layouts.dashboard')
{{-- @extends('layouts.partials.nav') --}}

@section('title')
    <h1>{{ $category->name }}</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{ $category->name }}</li>
@endsection

@section('content')
    <table border="1" class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = $category->products()->with('store')->paginate(5);
            @endphp
            @if ($products->count())
                @foreach ($products as $product)
                    <tr>
                        <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->store->name }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="btn btn-sm btn-outline-success">Edit</a>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">No products defined. </td>
                </tr>
            @endif
    </tbody>
    </table>
    <div class="mt-3">
        {{ $products->links() }}
    </div>


@endsection
