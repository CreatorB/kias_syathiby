<li class="timeline-item">
    <span class="timeline-point"><small>{{ $number }}</small></span>
    <div class="timeline-event">
        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
            <h6>{{ $title }}</h6>
            <span class="timeline-event-time">{{ $label }}</span>
        </div>
        <p class="mb-50">
            {{ $content }}
        </p>
        {{ $slot }}
    </div>
</li>
