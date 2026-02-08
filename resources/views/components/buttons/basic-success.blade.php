@props(['color'])

<button {{ $attributes->merge([
    'class' => 'btn btn-'.$color.'',
    'type' => 'button'
])}}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
