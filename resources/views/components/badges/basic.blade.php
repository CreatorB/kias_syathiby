@props(['color'])

<span {{ $attributes->merge([
    'class' => 'badge bg-'.$color.''
])}}>
    {{ $slot }}
</span>
