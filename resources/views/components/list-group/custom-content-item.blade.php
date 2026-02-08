<a
{{ $attributes->merge([
    'href' => '#' ?? '',
    'class' => 'list-group-item list-group-item-action'
]) }}>
    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">{{ $title }}</h5>
        <small class="text-secondary">{{ $label }}</small>
    </div>
    <p class="card-text">
        {{ $content }}
    </p>
    <div class="d-flex justify-content-between">
        <small class="text-secondary">{{ $subContent }}</small>
        @isset($sideContent)
        {{ $sideContent }}
        @endisset
    </div>
</a>
