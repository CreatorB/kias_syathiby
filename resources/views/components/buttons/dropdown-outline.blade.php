<div
{{ $attributes->merge([
    'class' => 'btn-group'
]) }}>
    <button type="button" class="btn btn-sm btn-outline-{{ $color }}">{{ $buttonName }}</button>
    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="visually-hidden">Toggle Dropdown</span>
    </button>
    {{ $slot }}
    <!--Isi dengan dropdown-menu-->
</div>
