<div class="btn-group">
    <button type="button" class="btn btn-sm btn-outline-secondary">
        {{ $namaButton }}
    </button>
    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="visually-hidden">Button</span>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        {{ $slot }}
    </div>
</div>
