<div class="dropdown-menu dropdown-menu-end">
    {{ $slot }}
    @isset($devider)
    <div class="dropdown-divider">{{ $devider }}</div>
    @endisset
</div>
