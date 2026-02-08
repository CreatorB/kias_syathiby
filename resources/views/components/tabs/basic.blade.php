<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="tab-kendala-jurnal" data-bs-toggle="tab" href="#kendalaJurnal" aria-controls="kendalaJurnal" role="tab" aria-selected="true">Kendala Jurnal</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab-kendala-santri" data-bs-toggle="tab" href="#kendalaSantri" aria-controls="kendalaSantri" role="tab" aria-selected="false">Kendala Santri</a>
    </li>
</ul>
<div class="tab-content">
    <!--Tab Kendala Jurnal-->
    <div class="tab-pane active" id="kendalaJurnal" aria-labelledby="tab-kendala-jurnal" role="tabpanel">
        <x-list-group.custom-content>
            <div @if($this->listKendalaJurnal->count() >= 3) class="scroller3" @endif>
                @forelse ($this->listKendalaJurnal as $kendala)
                    <x-list-group.custom-content-item>
                        <x-slot name="title">#{{ $kendala->nomor_tiket }}</x-slot>
                        <x-slot name="label">{{ TanggalHelper::konversiTanggal($kendala->created_at) }}</x-slot>
                        <x-slot name="content">
                            <span class="text-muted">({{ $kendala->logJurnal?->kategori }}) {{ $kendala->logJurnal?->mapel }}</span>
                            <br>
                            Kendala : Mati listrik</x-slot>
                        <x-slot name="subContent">Penyelesaian :
                                <strong class="text-danger">Belum</strong>
                        </x-slot>
                    </x-list-group.custom-content-item>
                @empty
                    <x-alerts.simple-alert class="alert-danger">
                            <x-slot name="body">Mohon maaf, tidak ada data yang bisa ditampilkan</x-slot>
                    </x-alerts.simple-alert>
                @endforelse

                <!--Spinner Loading-->
                @if ($this->listKendalaJurnal->hasMorePages())
                <div class="mt-1">
                    <livewire:components.load-more-button :$tambahData />
                </div>
                @endif
                <!--#Spinner Loading-->
            </div>
        </x-list-group.custom-content>
    </div>
    <!--#Tab Kendala Jurnal-->

    <!--Tab Kendala Santri-->
    <div class="tab-pane" id="kendalaSantri" aria-labelledby="tab-kendala-santri" role="tabpanel">
        <p>
            Dragée jujubes caramels tootsie roll gummies gummies icing bonbon. Candy jujubes cake cotton candy.
            Jelly-o lollipop oat cake marshmallow fruitcake candy canes toffee. Jelly oat cake pudding jelly beans
            brownie lemon drops ice cream halvah muffin. Brownie candy tiramisu macaroon tootsie roll danish.
        </p>
        <p>
            Croissant pie cheesecake sweet roll. Gummi bears cotton candy tart jelly-o caramels apple pie jelly
            danish marshmallow. Icing caramels lollipop topping. Bear claw powder sesame snaps.
        </p>
    </div>
    <!--#Tab Kendala Santri-->
</div>
