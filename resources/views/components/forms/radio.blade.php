@props([
'name', 'options', 'checked' => false, 'label' => false,
])

@if($label)
    <label for="">{{ $label }}</label>
@endif

@foreach($options as $value => $text)

    <div class="col-lg-3 mg-t-20 mg-lg-t-0">
        <label class="rdiobox">
            <input type="radio" name="{{ $name }}" value="{{ $value }}"
                                      @checked(old($name, $checked) == $value)
                {{ $attributes->class([
                    'is-invalid' => $errors->has($name)
                ]) }}>
            <span>{{ $text }}</span>
        </label>
    </div>


@endforeach

