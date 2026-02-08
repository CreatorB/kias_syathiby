<div
{{ $attributes->merge([
    'class' => 'modal fade',
    'id' => '',
]) }}>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <h1 class="address-title text-center mb-1">{{ $modalTitle }}</h1>
                @isset($modalSubTitle)
                <p class="address-subtitle text-center mb-2 pb-75">{{ $modalSubTitle }}</p>
                @endisset

                {{ $slot }}
                {{-- <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary me-1 mt-2">
                        {{ $buttonSubmit }}
                    </button>
                    <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                        {{ $buttonClose }}
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
