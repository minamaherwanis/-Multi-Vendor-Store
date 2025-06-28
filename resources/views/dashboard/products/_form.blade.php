<div class="form-group">
    <x-form.input label="Product Name" name="name" value="{{ $product->name }}" type="text" />
</div>

<div class="form-group">
    <label for="category_id">Category</label>
    <select name="category_id" class="form-control" id="category_id">
        <option value="">Primary Category</option>
        @foreach (App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <x-form.textarea label="Description" name="description" value="{{ $product->description }}" />
</div>

<div class="form-group">
    <x-form.input type="file" name="image" label="Image" accept="image/*" />
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50">
    @endif
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<div class="form-group">
    <x-form.input label="Price" name="price" value="{{ $product->price}}"  />
</div>
<div class="form-group">
    <x-form.input label="Compare Price" name="compare_price" value="{{ $product->compare_price }}"  />
</div>
@php
    $tagsValue = old('tags') ?? ($product->tags ? $product->tags->pluck('name')->implode(',') : '');
@endphp
<div class="form-group">
<x-form.input label="Tags" name="tags" value="{{ $tagsValue }}" />

</div>

<div class="form-group">
    <label>Status</label>
    <div>
        <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft','archived' => 'Archived']" />
    </div>
    @error('status')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
