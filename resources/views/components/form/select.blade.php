{{-- <div class="mb-3">
    <label for="{{ $id ?? $name }}" class="form-label">{{ $label }}</label>

    <select
        name="{{ $name }}"
        {{ $attributes->class([
                'form-control',
                'is-invalid' => $errors->has($name)
            ]) }}

        @foreach($options as $value => $text)
            <option value="{{  $value }}" @elected($value==$selected)>
                {{$text}}
            </option>
        @endforeach
    </select>

<x-form.validation-feedback :name="$name"/> --}}
@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'id' => null,
])

<div class="mb-3">
    @if ($label)
        <label for="{{ $id ?? $name }}" class="form-label">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($name),
        ]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>

    {{-- <x-form.validation-feedback :name="$name" /> --}}
</div>

