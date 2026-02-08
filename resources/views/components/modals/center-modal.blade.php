<div {{ $attributes->class(['modal fade'])->merge(['id' => '', 'tabindex' => '-1', 'aria-hidden' => 'true']) }}>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1">{{ $modal_title }}</h1>
                @isset($modal_subtitle)
                <p class="text-center">{{ $modal_subtitle }}</p>
                @endisset
                @isset($modal_form)
                    {{ $modal_form }}
                @endisset
            </div>
        </div>
    </div>
</div>
