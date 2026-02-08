<div class="card">
    @isset($cardHeader)
        <div class="card-header">
            <h3 class="card-title mb-50">{{ $cardHeader }}</h3>
            @isset($subHeader)
            <div class="d-flex align-items-center">
                {{ $subHeader }}
            </div>
            @endisset
        </div>
    @endisset

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
