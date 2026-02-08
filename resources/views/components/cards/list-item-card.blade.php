<div class="transaction-item">
    <div class="d-flex flex-row">
        <!--$avatar Attributes Hint : bg-light-success-->
        <div {{ $avatar->attributes->class(['avatar rounded']) }}>
            {{ $avatar }}
            <div class="avatar-content">
                {{ $avatar_icon }}
            </div>
        </div>
        <div class="transaction-info">
            <h6 class="transaction-title">{{ $item_title }}</h6>
            <small>{{ $item_content }}</small>
        </div>
    </div>
    <!--$alert Attributes Hint : text-primary-->
    <div {{ $alert->attributes->class(['fw-bolder']) }}>
        {{ $alert }}
    </div>
</div>
