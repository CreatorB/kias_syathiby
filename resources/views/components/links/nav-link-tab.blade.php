<li class="nav-item">
    <a {{ $link->attributes->class(['nav-link'])->merge([
        'href' => '',
        'data-bs-toggle' => 'tab',
        'role' => 'tab',
    ]) }}>
        {{ $link }}
    </a>
</li>
