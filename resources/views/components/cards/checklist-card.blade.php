<div class="card business-card">
    <div class="card-header pb-1">
        <h4 class="card-title">{{ $title }}</h4>
    </div>
    <div class="card-body">
        @isset($keterangan)
        <p class="card-text">{{ $keterangan }}</p>
        @endisset
        <h6 class="mb-75">{{ $subTitle }}</h6>
        <div class="business-items">
            <div class="business-item">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="form-check-label" for="business-checkbox-1">{{ $check1 }}</label>
                    <span {{ $option1->attributes->class(['badge']) }}>
                        {{ $option1 }}
                    </span>
                </div>
            </div>
            @isset($check2)
            <div class="business-item">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="form-check-label" for="business-checkbox-1">{{ $check2 }}</label>
                    <span {{ $option2->attributes->class(['badge']) }}>
                        {{ $option2 }}
                    </span>
                </div>
            </div>
            @endisset
        </div>
        <div class="d-grid">
            {{ $slot }}
        </div>
    </div>
</div>
