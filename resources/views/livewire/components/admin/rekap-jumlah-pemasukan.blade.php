<div>
    <div class="card card-congratulation-medal">
        <div class="card-body">
            <h5>Pemasukan PSB {{ $tahunPsb }}</h5>
            <x-items.light-badge color="danger">Menunggu Verifikasi : {{ $verifikasiTransfer }}</x-items.light-badge>
            <h3 class="mb-75 mt-4 text-primary">
                {{ \App\Helpers\MataUangHelper::rupiah($totalPemasukan) }}
            </h3>
            <a wire:navigate href="{{ route('admin::verifikasi_transfer') }}">
                <button type="button" class="btn btn-primary">Lihat Detail</button>
            </a>
            <img src="{{ asset('style/app-assets/images/illustration/badge.svg') }}" class="congratulation-medal" alt="Medal Pic" />
        </div>
    </div>
</div>
