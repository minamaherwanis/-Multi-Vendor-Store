<div class="form-group">


    <x-form.input label="Category Name" name="name" value="{{ $category->name }}" type="text" />


</div>

<div class="form-group">
    <label for="parent_id">Category Parent</label>
    <select name="parent_id" class="form-control" id="parent_id">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="form-group">

    
    {{-- <label for="description">Description</label>
    <textarea name="description" class="form-control" id="description">{{ old('description', $category->description) }}</textarea>
    @error('description')
        {{ $message }}
    @enderror --}}


    <x-form.textarea label="Description" name="description" value="{{ $category->description }}" />

</div>

<div class="form-group">

    <x-form.input type="file" name="image" label="Image"   accept="image/*"/>
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" height="50">
    @endif
    @error('image')
        {{ $message }}
    @enderror
</div>

<div class="form-group">
    <label>Status</label>
    <div>
<x-form.radio name="status" :checked="$category->status" :options="['active'=>'Active','archived'=>'Archived']" />
    </div>
    @error('status')
        {{ $message }}
    @enderror
</div>

<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">{{ $button_label }}</button>
</div>
