
      @props(['name', 'label' => '', 'value' => null])

      <label for="">{{ $label }}</label>
      <textarea name="{{ $name }}" id="{{ $name }}" class="form-control">{{ old($name, $value) }}</textarea>
            {{$attributes}}
      @error($name)
          <div class="text-danger">
              {{ $message }}
          </div>
      @enderror
