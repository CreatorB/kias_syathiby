<div>
    <x-modals.project-modal id="{{ $idModal }}" wire:ignore.self>
        <x-slot:title>Verifikasi Bukti Transfer</x-slot:title>
        <form wire:submit='simpanStatus'>
            <div class="row">
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Nama Santri</x-inputs.label>
                    <x-inputs.basic value="{{ $dataPendaftar?->nama }}" disabled/>
                </div>
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Program</x-inputs.label>
                    <x-inputs.basic value="{{ $dataPendaftar?->program->nama_program }}" disabled/>
                </div>
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Tanggal Daftar</x-inputs.label>
                    <x-inputs.basic value="{{ \App\Helpers\TanggalHelper::hariTanggalWaktu($dataPendaftar?->created_at) }}" disabled/>
                </div>
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Status Transfer</x-inputs.label>
                    <x-inputs.select wire:model='statusTransfer'>
                        <x-inputs.select-option value="Cek">Cek</x-inputs.select-option>
                        <x-inputs.select-option value="Valid">Valid</x-inputs.select-option>
                        <x-inputs.select-option value="Invalid">Tidak Valid</x-inputs.select-option>
                    </x-inputs.select>
                </div>
                <div class="col-12 mb-1">
                    <x-inputs.label>Bukti Transfer</x-inputs.label>
                    <br/>
                    <a href="{{ asset('berkas/'.$dataPendaftar?->tahun_psb.'/'.$dataPendaftar?->transfer.'') }}" target="_blank">
                        <img src="{{ asset('berkas/'.$dataPendaftar?->tahun_psb.'/'.$dataPendaftar?->transfer.'') }}" width="300" height="auto"/>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <x-buttons.basic color="primary" type="submit">Simpan</x-buttons.basic>
                    <x-buttons.outline color="dark" data-bs-dismiss="modal">Batal</x-buttons.outline>
                </div>
            </div>
        </form>
    </x-modals.project-modal>
</div>
