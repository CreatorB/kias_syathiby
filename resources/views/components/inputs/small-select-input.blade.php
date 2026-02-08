<select {{ $attributes->class(['form-select form-select-sm'])->merge(['name' => '']) }}>
    {{ $slot }}
</select>
