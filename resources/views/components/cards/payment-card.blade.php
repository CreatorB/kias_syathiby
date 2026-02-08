<div class="cardMaster rounded border p-1 mb-1">
    <div class="d-flex justify-content-between flex-sm-row flex-column">
        <div class="card-information">
            <div class="d-flex align-items-center mb-50">
                <h4 class="mb-0">{{ $judul }}</h4>
            </div>
            <span class="card-number">
                @isset($sub_judul1)
                    {{ $sub_judul1 }}
                @endisset
            </span><br>
            <span class="card-number">
                @isset($sub_judul2)
                {{ $sub_judul2 }}
                @endisset
            </span>
        </div>
        <div class="d-flex flex-column text-start text-lg-end">
            <div class="d-flex order-sm-0 order-1 mt-sm-0">
                {{ $slot }}
            </div>
            @isset($keterangan)
            <span class="mt-1">{{ $keterangan }}</span>
            @endisset
        </div>
    </div>
</div>
