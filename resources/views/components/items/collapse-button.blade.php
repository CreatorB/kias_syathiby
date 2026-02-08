<button class="btn btn-sm btn-outline-{{ $color }} me-1"
{{ $attributes->merge([
    'type' => 'button',
    'data-bs-toggle' => 'collapse',
    'data-bs-target' => '#collapseExample' ?? '',
    'aria-expanded' => 'false',
    'aria-controls' => 'collapseExample' ?? ''
]) }}>
    @isset($icon)
        {{ $icon }}
    @endisset
    {{ $slot }}
</button>
