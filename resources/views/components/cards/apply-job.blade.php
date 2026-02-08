<div class="card card-apply-job">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="d-flex flex-row">
                @isset($avatar)
                <div class="avatar me-1">
                    {{ $avatar }}
                    {{-- <img src="../../../app-assets/images/portrait/small/avatar-s-20.jpg" alt="Avatar" width="42" height="42" /> --}}
                </div>
                @endisset
                <div class="user-info">
                    <h5 class="mb-0">{{ $title }}</h5>
                    <small class="text-muted">{{ $subTitle }}</small>
                </div>
            </div>
            @isset($badge)
                {{ $badge }}
            @endisset
        </div>
        @isset($headingContent)
        <h5 class="apply-job-title">
            {{ $headingContent }}
        </h5>
        @endisset

        <p class="card-text">
            {{ $content }}
        </p>
        @isset($info)
        {{ $info }}
        @endisset
        @isset($highlight)
        <div class="apply-job-package bg-light-primary rounded">
            <div>
                <h5 class="d-inline me-25">{{ $highlight }}</h5>
            </div>
        </div>
        @endisset
        {{ $slot }}
    </div>
</div>
