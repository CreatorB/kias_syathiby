<div class="help-center-header rounded d-flex flex-column justify-content-center align-items-center bg-help-center">
    <h3 class="text-center"> Anda sudah mendaftar? </h3>
    <p class="text-center px-3 mb-2">Cek status pendaftaran anda disini!</p>
    <div class="input-wrapper mb-3 input-group input-group-lg input-group-merge">
      <span class="input-group-text" id="basic-addon1"><i class="ti ti-search"></i></span>
      <input type="text" class="form-control" placeholder="Ketik nama anda..." aria-label="Search" wire:model.live="search" aria-describedby="basic-addon1" />
    </div>

    @if (!empty($search))
        @if($dataSantri->count() > 0)
            @foreach ($dataSantri as $item)
                @php
                    $tanggal = \Carbon\Carbon::parse($item->created_at);
                    $tanggalIndo = $tanggal->isoFormat('D MMMM Y');
                    $jamIndo = $tanggal->format('H:i:s');
                @endphp
                <div class="d-flex mt-2" wire:key='nama-{{ $item->id }}'>
                    <div class="role-heading">
                    <h4 class="mb-1">{{ $item->nama }}</h4>
                    Jenis Kelamin : <b>{{ $item->jk }}</b><br>
                    Program : <b>{{ $item->nama_program }}</b><br>
                    Tanggal Daftar : <b>{{ $tanggalIndo }}</b>
                    </div>
                    <a href="/cari-nama" class="text-muted">
                        <button class="btn btn-success btn-sm">Detail</button>
                    </a>
                </div>
            @endforeach
        @else
            <b style="color:red" class="text-center">Mohon maaf, kami tidak dapat menemukan data yang anda cari.
            Silahkan daftar terlebih dahulu!</b>
        @endif
    @endif
</div>
