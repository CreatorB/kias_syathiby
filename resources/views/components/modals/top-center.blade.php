<div
{{ $attributes->merge([
    'class' => 'modal fade text-start',
    'id' => '',
    'tabindex' => "-1",
]) }}>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ $header }}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @isset($title)
                    <h5>{{ $title }}</h5>
                @endisset
                <p>
                    {{ $content }}
                </p>
            </div>
            <div class="modal-footer">
                @isset($confirmButton)
                    <button {{ $confirmButton->attributes->merge([
                        'type' => 'button' ?? '',
                        'class' => 'btn btn-primary' ?? ''
                    ]) }}>
                        {{ $confirmButton }}
                    </button>
                @endisset
                <button class="btn btn-dark" type="button" data-bs-dismiss="modal">
                    {{ $cancelButton}}
                </button>
            </div>
        </div>
    </div>
</div>
