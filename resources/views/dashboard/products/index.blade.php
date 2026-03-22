@extends('layouts.dashboard')

@section('title')
    <h1>Products</h1>
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    <div class="mb-5">
        @if (auth()->user()->store_id)
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
        @endif
    </div>

    <x-alert type="success" />
    <x-alert type="info" />

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')"/>
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status')=='active')>active</option>
            <option value="archived" @selected(request('status')=='archived')>archived</option>
        </select>
        <button class="btn btn-dark mx-2">Filter</button>
    </form>

    <table border="1" class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
                @if (auth()->user()->store_id)
                    <th colspan="2">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if ($products->count())
                @foreach ($products as $product)
                    <tr>
                        <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'no category' }}</td>
                        <td>{{ $product->store->name }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at }}</td>
                        @if (auth()->user()->store_id)
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                            </td>
                            <td>
                                <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">No products defined.</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}
@endsection