<li class="timeline-item">
    <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
    <div class="timeline-event">
        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
            <h6 class="mb-50">{{ $title }}</h6>
            <span class="timeline-event-time">{{ $label }}</span>
        </div>
        <p>{{ $content }}</p>
        <hr />
        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
            <div class="d-flex flex-row align-items-center">
                @isset($avatar)
                <div class="avatar me-1">
                    <img src="../../../app-assets/images/avatars/1-small.png" alt="Avatar" height="32" width="32" />
                </div>
                @endisset
                <span>
                    <p class="mb-0">{{ $item }}</p>
                    <span class="text-muted">{{ $info }}</span>
                </span>
            </div>
            <div class="d-flex align-items-center cursor-pointer mt-sm-0 mt-50">
                {{ $slot }}
                {{-- <i data-feather="message-square" class="me-1"></i>
                <i data-feather="phone-call"></i> --}}
            </div>
        </div>
    </div>
</li>
