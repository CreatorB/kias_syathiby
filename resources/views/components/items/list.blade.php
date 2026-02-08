<div>
    <h6 class="fw-bolder mt-1">{{ $title }}</h6>
    <div class="d-flex justify-content-between border-bottom mb-1 pb-1">
        <span>{{ $detail }}</span>
        <div class="action-icons">
            <a {{ $icon1->attributes->class(['text-body me-50'])->merge([]) }}>
                @isset($icon1)
                    {{ $icon1 }}
                @endisset
            </a>
            <a {{ $icon2->attributes->class(['text-body'])->merge(['data-bs-toggle' => 'collapse', 'href' => '']) }}>
                @isset($icon2)
                    {{ $icon2 }}
                @endisset
            </a>
        </div>
    </div>
    {{ $slot }}
</div>
