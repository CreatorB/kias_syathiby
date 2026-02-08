<button {{ $attributes->class(['btn btn-outline-dark'])->merge(['type' => '']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
