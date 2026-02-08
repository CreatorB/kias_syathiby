<div class="cardMaster rounded border p-2 mb-1">
    <div class="d-flex justify-content-between flex-sm-row flex-column">
        <div class="card-information">
            <div class="d-flex align-items-center mb-50">
                <h6 class="mb-0">{{ $title }}</h6>
                @isset($label)
                    {{ $label }}
                    <!--Isi dengan badge-->
                @endisset
            </div>
            <span class="card-number">{{ $content }}</span>
        </div>
        <div class="d-flex flex-column text-start text-lg-end">
            @isset($buttonAction)
            <div class="d-flex order-sm-0 order-1 mt-1 mt-sm-0">
                <button class="btn btn-outline-primary me-75" data-bs-toggle="modal" data-bs-target="#editCard">
                    Edit
                </button>
                <button class="btn btn-outline-secondary">Delete</button>
            </div>
            @endisset
            <span class="mt-2">
                {{ $option }}
            </span>
        </div>
    </div>
</div>
