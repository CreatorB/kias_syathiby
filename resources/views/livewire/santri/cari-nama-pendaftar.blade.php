<div>
    <div class="input-wrapper mb-3 input-group input-group-lg input-group-merge">
      <span class="input-group-text"><i class="ti ti-search"></i></span>
      <input type="text" class="form-control" placeholder="Ketik nama anda..." wire:model.live="search" />
    </div>

    @if (!empty($search))
        @if($dataSantri->count() > 0)
            @foreach ($dataSantri as $item)
                @php
                    $tanggal = \Carbon\Carbon::parse($item->created_at);
                    $tanggalIndo = $tanggal->isoFormat('D MMMM Y');
                @endphp
                <div class="d-flex mt-2 align-items-start justify-content-between p-2 border rounded mb-2" wire:key='nama-{{ $item->id }}'>
                    <div>
                        <h6 class="mb-1">{{ $item->nama }}</h6>
                        <small class="text-muted">
                            {{ $item->jk }} | {{ $item->nama_program }} | {{ $tanggalIndo }}
                        </small><br>
                        <small>Kode: <strong>{{ $item->kode_registrasi }}</strong></small>
                    </div>
                    <a href="/revisi-berkas/{{ $item->kode_registrasi }}" class="btn btn-success btn-sm">Detail</a>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning text-center">
                Mohon maaf, kami tidak dapat menemukan data yang anda cari. Silakan daftar terlebih dahulu!
            </div>
        @endif
    @endif
</div>