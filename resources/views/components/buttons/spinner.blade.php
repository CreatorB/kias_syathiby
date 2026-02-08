<button
{{ $attributes->merge([
    'class' => 'btn btn-outline-primary',
    'type' => 'button',
]) }}>
    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    @isset($buttonName)
        <span class="ms-25 align-middle">
            {{ $buttonName }}
        </span>
    @endisset
</button>
