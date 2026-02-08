<button {{ $attributes->class(['btn btn-primary'])->merge(['type' => '']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
