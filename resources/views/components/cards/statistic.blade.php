<div class="card card-statistics">
    <div class="card-header">
        <h3 class="card-title">{{ $title }}</h3>
        <div class="d-flex align-items-center">
            <p class="card-text me-25 mb-0">{{ $subTitle }}</p>
        </div>
    </div>
    <div class="card-body statistics-body">
        <div class="row mb-0">
            <div class="col-lg-3 mb-1">
                <div class="d-flex flex-row">
                    <div
                    {{ $attributes->merge(['class' => 'avatar me-2 bg-light-'.$colorOne]) }}>
                        <div class="avatar-content">
                            {{ $iconOne }}
                            {{-- <i data-feather="trending-up" class="avatar-icon"></i> --}}
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0">{{ $counterOne }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ $subCounterOne }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-1">
                <div class="d-flex flex-row">
                    <div
                    {{ $attributes->merge(['class' => 'avatar me-2 bg-light-'.$colorTwo]) }}>
                        <div class="avatar-content">
                            {{ $iconTwo }}
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0">{{ $counterTwo }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ $subCounterTwo }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 mb-1">
                <div class="d-flex flex-row">
                    <div
                    {{ $attributes->merge(['class' => 'avatar me-2 bg-light-'.$colorThree]) }}>
                        <div class="avatar-content">
                            {{ $iconThree }}
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0">{{ $counterThree }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ $subCounterThree }}</p>
                    </div>
                </div>
            </div>

            @isset($iconFour)
            <div class="col-lg-3 mb-1">
                <div class="d-flex flex-row">
                    <div
                    {{ $attributes->merge(['class' => 'avatar me-2 bg-light-'.$colorFour]) }}>
                        <div class="avatar-content">
                            {{ $iconFour }}
                        </div>
                    </div>
                    <div class="my-auto">
                        <h4 class="fw-bolder mb-0">{{ $counterFour }}</h4>
                        <p class="card-text font-small-3 mb-0">{{ $subCounterFour }}</p>
                    </div>
                </div>
            </div>
            @endisset
        </div>
    </div>
</div>
