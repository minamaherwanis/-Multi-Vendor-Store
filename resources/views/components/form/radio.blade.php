@props(['name', 'options', 'checked' => false])

@foreach ($options as $value => $text)
    <div class="form-check">
        <input 
            type="radio" 
            name="{{ $name }}" 
            id="{{ $name }}_{{ $value }}" 
            value="{{ $value }}"
            {{ $attributes->class([
                'form-check-input',
                'is-invalid' => $errors->has($name)
            ]) }}
            @checked(old($name, $checked) == $value)
        >
        <label class="form-check-label" >{{ $text }}</label>
    </div>
@endforeach