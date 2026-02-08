<button {{ $attributes->class(['btn btn-dark'])->merge(['type' => '']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
