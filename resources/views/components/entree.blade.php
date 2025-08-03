@props([
    'type' => 'text',
    'name',
    'id' => $name,
    'value' => '',
    'required' => false,
    'placeholder' => '',
    'class' => ''
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ old($name, $value) }}"
    @if($required) required @endif
    placeholder="{{ $placeholder }}"
    {{ $attributes->merge(['class' => "border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm $class"]) }}
/>
