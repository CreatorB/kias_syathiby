<div class="p-1 border">
    {{ $slot }}
    {{-- @if ($data->ujianMurojaah->count() == 0)
        <em class="text-danger">Santri belum mengikuti ujian</em>
    @else
    <span>
        Nilai : <b>{{ $data->ujianMurojaah[0]->nilai_murojaah }}</b> <br>
        @if ($data->ujianMurojaah[0]->ketuk != NULL)
            Ketuk : <b>{{ $data->ujianMurojaah[0]->ketuk }}x</b> <br>
            Tuntun : <b>{{ $data->ujianMurojaah[0]->tuntun }}x</b> <br>
            Gugur : <b>{{ $data->ujianMurojaah[0]->gugur }}x</b> <br><br>
        @endif

        Waktu Ujian : <b>{{ $data->ujianMurojaah[0]->created_at->isoFormat('dddd, D MMMM Y') }}</b>
    </span>
    @endif --}}
</div>
