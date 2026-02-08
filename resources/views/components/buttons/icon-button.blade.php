<button {{ $attributes->class(['btn'])->merge(['type' => 'button']) }}>
    @isset($icon)
    {{ $icon }}
    @endisset
    <span>
        {{ $name }}
    </span>
</button>
