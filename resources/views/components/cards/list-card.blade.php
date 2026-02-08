<div {{ $attributes->class(['card card-transaction']) }}>
    <div class="card-header">
        <h4 class="card-title">{{ $title }}</h4>
    </div>
    <div class="card-body">
        <!--List Item Card-->
        {{ $slot }}
    </div>
</div>
