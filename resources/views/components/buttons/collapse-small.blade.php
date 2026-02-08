<div>
    <button {{$buttonName->attributes->class(['btn btn-sm'])->merge([
        'type' => 'button',
        'data-bs-toggle' => 'collapse',
        'data-bs-target' => '#collapseExample' ?? '',
        'aria-expanded' => 'true', 'aria-controls' => 'collapseExample'])}}>
        {{ $buttonName }}
    </button>

    @isset($resetButton)
        {{ $resetButton }}
    @endisset

    <div
    {{ $content->attributes->merge([
        'class' => 'collapse',
        'id' => 'collapseExampe' ?? ''
    ]) }}>
        {{ $content }}
    </div>
</div>
