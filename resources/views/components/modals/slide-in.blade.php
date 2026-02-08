<div
{{ $attributes->merge([
    'class' => 'modal modal-slide-in new-user-modal fade',
    'id' => ''
]) }}>
    <div class="modal-dialog">
        <div class="add-new-user modal-content pt-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ $header }}</h5>
            </div>
            <div class="modal-body flex-grow-1">
                {{ $slot }}
                {{-- <div class="mb-2"></div> --}}
                {{-- <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button> --}}
                @isset($cancelButton)
                <button class="btn btn-outline-dark mt-0" data-bs-dismiss="modal">
                    {{ $cancelButton }}
                </button>
                @endisset
            </div>
        </div>
    </div>
</div>
