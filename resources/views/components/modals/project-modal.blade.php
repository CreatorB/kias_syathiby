<div {{ $attributes->class(['modal fade'])->merge(['id' => '', 'tabindex' => '-1', 'aria-hidden' => 'true']) }}>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-4">
                <h1 class="text-center mb-1">
                    {{ $title }}
                </h1>
                @isset($subTitle)
                <p class="text-center">
                    {{ $subTitle }}
                </p>
                @endisset


                @isset($option)
                {{ $option }}
                @endisset
                {{-- <x-slot name="option">
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-1">
                            <div class="d-flex align-items-center me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-users font-medium-2 me-50">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <p class="fw-bolder mb-0">{{ $detailIzin->nama_santri }}</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 mb-1">
                            <div class="d-flex align-items-center me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-grid font-medium-2 me-50">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                                <b
                                    @if ($detailIzin->status == 'Proses') class="text-warning"
                                @elseif ($detailIzin->status == 'Keluar')
                                    class="text-danger"
                                @else
                                    class='text-success' @endif>Status
                                    : {{ $detailIzin->status }}</b>
                            </div>
                        </div>
                    </div>
                </x-slot> --}}
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
