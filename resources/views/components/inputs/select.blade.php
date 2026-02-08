{{-- @props(['status']) --}}
<select {{ $attributes->class(['form-select'])->merge(['name' => '']) }}>
    {{ $slot }}
</select>
{{-- <select {{ $attributes->class(['form-select'])->merge(['name' => '', 'disabled' => $status ?? '' == 'disabled']) }}>
    {{ $slot }}
</select> --}}