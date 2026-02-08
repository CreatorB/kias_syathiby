<button {{ $attributes->class(['btn btn-warning'])->merge(['type' => '']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $slot }}
    </span>
</button>
