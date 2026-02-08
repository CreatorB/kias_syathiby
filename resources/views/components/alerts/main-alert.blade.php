<div {{ $attributes->class(['alert alert-dismissible fade show'])->merge(['role' => 'alert']) }}>
    @isset($heading)
    <div class="alert-heading">
        {{ $heading }}
    </div>
    @endisset
    <div class="alert-body">
        {{ $slot }}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
