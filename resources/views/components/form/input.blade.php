@props(['name', 'type' => 'text', 'value' => null, 'label' => false])

@if ($label)
    <label for="">{{ $label }}</label>
@endif

<input 
    type="{{ $type }}" 
    name="{{ $name }}" 
    id="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }}
>

@error($name)
    <div class="text-danger">
        {{ $message }}
    </div>
@enderror