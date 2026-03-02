@extends('layouts.dashboard')

@section('title', 'Create Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name"
               value="{{ old('name') }}"
               class="form-control">
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="store_id">Store</label>
        <select name="store_id" id="store_id" class="form-control">
            <option value="">Select Store</option>
            @foreach($stores as $store)
                <option value="{{ $store->id }}" @selected(old('store_id') == $store->id)>
                    {{ $store->name }}
                </option>
            @endforeach
        </select>
        @error('store_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        @error('description') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        @error('image') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-control">
        @error('price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="compare_price">Compare Price</label>
        <input type="number" name="compare_price" id="compare_price" value="{{ old('compare_price') }}" class="form-control">
        @error('compare_price') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label for="tags">Tags</label>
        <input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="form-control" placeholder="tag1,tag2,tag3">
        @error('tags') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" @selected(old('status') == 'active')>Active</option>
            <option value="draft" @selected(old('status') == 'draft')>Draft</option>
            <option value="archived" @selected(old('status') == 'archived')>Archived</option>
        </select>
        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection