<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">{{ $judul_halaman }}</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb" wire:ignore>
                        <li class="breadcrumb-item"><a href="/"><i data-feather='home'></i></a>
                        </li>
                        @isset($halaman1)
                        <li class="breadcrumb-item">
                            <a {{ $halaman1->attributes->class([''])->merge(['href' =>'']) }} wire:navigate>
                                {{ $halaman1 }}
                            </a>
                        </li>
                        @endif
                        @isset($halaman_aktif)
                        <li class="breadcrumb-item active">
                            {{ $halaman_aktif }}
                        </li>
                        @endisset
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
