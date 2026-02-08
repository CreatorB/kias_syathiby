<div class="card text-center">
    <div class="card-body">
        <div {{ $attributes->merge([
            'class' => 'avatar p-50 mb-1 bg-light-'.$color
        ]) }}>
            <div class="avatar-content">
                {{ $icon }}
                {{-- <i data-feather="eye" class="font-medium-5"></i> --}}
            </div>
        </div>
        <h2 class="fw-bolder">{{ $content }}</h2>
        <p class="card-text">{{ $subContent }}</p>
    </div>
</div>
