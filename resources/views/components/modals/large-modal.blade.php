<div {{ $attributes->class(['modal fade'])->merge(['id' => '', 'tabindex' => '-1', 'aria-hidden' => 'true']) }}>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-4 mx-50">
                <h1 class="address-title text-center mb-1" id="addNewAddressTitle">
                    {{ $modal_title }}
                </h1>
                @isset($modal_subtitle)
                <p class="address-subtitle text-center mb-2 pb-75">
                    {{ $modal_subtitle }}
                </p>
                @endisset

                <form {{ $form->attributes->class(['row gy-y gx-2'])->merge(['action' => '', 'method' => 'POST']) }}>
                    @isset($form)
                    {{ $form }}
                    @endisset
                    {{-- <div class="col-12 col-md-6">
                        <label class="form-label" for="modalAddressFirstName">First Name</label>
                        <input type="text" id="modalAddressFirstName" name="modalAddressFirstName" class="form-control" placeholder="John" data-msg="Please enter your first name" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalAddressLastName">Last Name</label>
                        <input type="text" id="modalAddressLastName" name="modalAddressLastName" class="form-control" placeholder="Doe" data-msg="Please enter your last name" />
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-1 mt-2">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary mt-2" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</div>
