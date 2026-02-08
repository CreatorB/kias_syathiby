<div
{{ $attributes->merge([
    'class' => 'offcanvas offcanvas-end',
    'tabindex' => '-1',
    'id' => 'offcanvasEnd' ?? '',
]) }}>
    <div class="offcanvas-header d-flex">
        <div>
            <h5 class="offcanvas-title">{{ $title }}</h5>
        </div>
        <div>
            @isset($addIcon)
                {{ $addIcon }}
            @endisset
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body flex-grow-0">
        @isset($subTitle)
        <div class="mb-2">
            <small class="text-muted">{{ $subTitle }}</small>
        </div>
        @endisset

        {{ $slot }}
        @isset($confirmButton)
            <button
            {{ $confirmButton->attributes->merge([
                'type' => 'button' ?? '',
                'class' => 'btn btn-primary mb-1 d-grid w-100'
            ]) }}>
                {{ $confirmButton }}
            </button>
        @endisset

        @isset($cancelButton)
            <button type="button" class="mt-1 btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                {{ $cancelButton }}
            </button>
        @endisset
    </div>
</div>

<!--Trigger Action Button-->
{{-- <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd">
    Toggle End
</button> --}}
<!--#Trigger Action Button-->

