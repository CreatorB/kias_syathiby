<div class="card">
    <div class="card-header">
        <div>
            <h2 class="fw-bolder mb-0">{{ $title }}</h2>
            <p class="card-text">{{ $subTitle }}</p>
        </div>
        <div class="avatar bg-light-{{ $color }} p-50 m-0">
            <div class="avatar-content" wire:ignore>
                <!--Gunakan feathericon dan tambah class font-medium-5-->
                {{ $icon }}
            </div>
        </div>
    </div>
</div>
