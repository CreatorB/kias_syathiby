<div class="form-check form-switch form-check-{{ $color }}">
    @isset($checkBox)
    {{ $checkBox }}
    @endisset

    {{ $slot }}
</div>
