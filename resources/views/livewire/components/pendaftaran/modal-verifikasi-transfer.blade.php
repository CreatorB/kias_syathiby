<div>
    <x-modals.project-modal id="{{ $idModal }}" wire:ignore.self>
        <x-slot:title>Verifikasi Bukti Transfer</x-slot:title>
        <form wire:submit='simpanStatus'>
            <div class="row">
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Nama Santri</x-inputs.label>
                    <x-inputs.basic value="{{ $data?->nama }}" disabled/>
                </div>
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Program</x-inputs.label>
                    <x-inputs.basic value="{{ $data?->program->nama_program }}" disabled/>
                </div>
                <div class="col-lg-6 col-12 mb-1">
                    <x-inputs.label>Tanggal Daftar</x-inputs.label>
                    <x-inputs.basic value="{{ \App\Helpers\TanggalHelper::hariTanggalWaktu($data?->created_at) }}" disabled/>
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
                    @if($data?->transfer && $data?->tahun_psb)
                        @php
                            $transferPath = 'berkas/'.$data->tahun_psb.'/'.$data->transfer;
                            $transferExists = file_exists(public_path($transferPath));
                        @endphp
                        @if($transferExists)
                            <a href="{{ asset($transferPath) }}" target="_blank">
                                <img src="{{ asset($transferPath) }}" width="300" height="auto"/>
                            </a>
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px; width: 300px;">
                                <span class="text-muted"><i class="ti ti-photo-off me-1"></i> File tidak ditemukan</span>
                            </div>
                        @endif
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px; width: 300px;">
                            <span class="text-muted"><i class="ti ti-info-circle me-1"></i> Bukti transfer belum diupload</span>
                        </div>
                    @endif
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
