<button {{ $attributes->class(['btn btn-outline-primary'])->merge(['type' => '']) }}>
    <span>
        {{ $slot }}
    </span>
    @isset($icon)
    {{ $icon }}
    @endisset
</button>
