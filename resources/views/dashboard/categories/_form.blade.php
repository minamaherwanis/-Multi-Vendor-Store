

 <div class="form-group">
      <label for="name">Category Name</label>
      <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}">
      @error('name')
      <div class="text-danger">
        {{$message}}
      </div>
      @enderror
  </div>

  <div class="form-group">
      <label for="parent_id">Category Parent</label>
      <select name="parent_id" class="form-control" id="parent_id">
          <option value="">Primary Category</option>
          @foreach ($parents as $parent)
              <option value="{{ $parent->id }}" @selected( old('parent_id',$category->parent_id) == $parent->id)>{{ $parent->name }}</option>
          @endforeach
      </select>
            @error('parent_id')
      <div class="text-danger">
        {{$message}}
      </div>
      @enderror
  </div>

  <div class="form-group">
      <label for="description">Description</label>
      <textarea name="description" class="form-control" id="description">{{ old('description',$category->description) }}</textarea>
      @error('description')
      {{$message}}
      @enderror
  </div>

  <div class="form-group">
      <label for="image">Image</label>
      <input type="file" name="image" class="form-control" id="image" accept="image/*">
      @if ($category->image)
          <img src="{{ asset('storage/' . $category->image) }}" alt="" height="50">
      @endif
      @error('image')
      {{$message}}
      @enderror
  </div>

  <div class="form-group">
      <label>Status</label>
      <div>
          <div class="form-check">
              <input class="form-check-input" type="radio" name="status" value="active" id="status_active"
                  @checked(old('status',$category->status) == 'active')>
              <label class="form-check-label" for="status_active">Active</label>
          </div>
          <div class="form-check">
              <input class="form-check-input" type="radio" name="status" value="archived" id="status_archived"
                  @checked(old('status',$category->status) == 'archived')>
              <label class="form-check-label" for="status_archived">Archived</label>
          </div>
      </div>
      @error('status')
      {{$message}}
      @enderror
  </div>

  <div class="form-group mt-3">
      <button type="submit" class="btn btn-primary">{{ $button_label }}</button>
  </div>
