<button {{ $attributes->class(['btn btn-outline-danger'])->merge(['type' => '']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
