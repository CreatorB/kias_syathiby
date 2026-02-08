<div class="d-flex flex-row meetings">
    @isset($icon)
        <div class="avatar bg-light-primary rounded me-1">
            <div class="avatar-content">
                {{ $icon }}
                {{-- <i data-feather="calendar" class="avatar-icon font-medium-3"></i> --}}
            </div>
        </div>
    @endisset
    <div class="content-body">
        <h6 class="mb-0">{{ $content }}</h6>
        <small>{{ $subContent }}</small>
    </div>
</div>
