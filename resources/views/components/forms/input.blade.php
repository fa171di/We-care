@props([
'type' => 'text', 'name', 'value' => '', 'label' => false , 'requiredInput' => false
])

@if($label)
    <label for="">{{ $label }}
        @if($requiredInput)
            <span class="tx-danger">{{$requiredInput}}</span>
        @endif</label>
@endif

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->class([
        'form-control',
    ]) }}
>

