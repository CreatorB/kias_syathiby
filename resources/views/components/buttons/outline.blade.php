@props(['color'])

<button {{ $attributes->class(['btn btn-outline-'.$color.''])->merge(['type' => 'button']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
