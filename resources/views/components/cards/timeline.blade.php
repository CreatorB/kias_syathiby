<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $header }}</h4>
    </div>
    <div class="card-body">
        @isset($action)
            {{ $action }}
        @endisset
        <div>
            <ul class="timeline">
                {{ $slot }}
            </ul>
        </div>
    </div>
</div>
