<a {{ $attributes->class(['dropdown-item'])->merge(['href' => '']) }}>
    <!--Isi slot dengan icon SVG-->
    {{ $slot }}
    <span>{{ $namaOpsi }}</span>
</a>
