<div class="card card-developer-meetup">
    @isset($avatar)
        <div class="meetup-img-wrapper rounded-top text-center">
            {{ $avatar }}
        </div>
    @endisset
    <div class="card-body">
        <div class="meetup-header d-flex align-items-center">
            <div class="meetup-day">
                <h6 class="mb-0">{{ $month }}</h6>
                <h3 class="mb-0">{{ $date }}</h3>
            </div>
            <div class="my-auto">
                <h4 class="card-title mb-25">{{ $title }}</h4>
                <p class="card-text mb-0">{{ $subTitle }}</p>
            </div>
        </div>
        {{ $slot }}
        @isset($actionButton)
            <div class="mt-1">
                {{ $actionButton }}
            </div>
        @endisset
    </div>
</div>
