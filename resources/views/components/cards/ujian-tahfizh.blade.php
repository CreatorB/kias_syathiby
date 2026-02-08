<div class="card card-developer-meetup">
    <div class="card-body">
        <div class="meetup-header d-flex align-items-center">
            <div class="meetup-day">
                <h6 class="mb-0">
                    {{ $card_title }}
                </h6>
                <h4 class="mb-0">
                    {{ $card_label }}
                </h4>
            </div>
            <div class="my-auto">
                <h4 class="card-title mb-25">{{ $card_name }}</h4>
                <p class="card-text mb-0">{{ $s->program }} | {{ $s->detail_kelas }}</p>
            </div>
        </div>
        <!--Agenda Ujian-->
        <div class="d-flex flex-row meetings">
            <div class="avatar bg-light-primary rounded me-1">
                <div class="avatar-content">
                    <svg class="avatar-icon font-medium-3" xmlns="http://www.w3.org/2000/svg"
                        width="30" height="30" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-calendar">
                        <rect x="3" y="4" width="18" height="18"
                            rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>
            <div class="content-body">
                <h6 class="mb-0">{{ $card_label1 }}</h6>
                <small>{{ $label1_content }}</small>
            </div>
        </div>
        <!--Ujian Terakhir-->
        <div class="d-flex flex-row meetings">
            <div class="avatar bg-light-primary rounded me-1">
                <div class="avatar-content">
                    <svg class="avatar-icon font-medium-3" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-flag">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                        <line x1="4" y1="22" x2="4" y2="15"></line>
                    </svg>
                </div>
            </div>
            <div class="content-body">
                <h6 class="mb-0">{{ $card_label2 }}</h6>
                <small>{{ $label2_content }}</small>
            </div>
        </div>
        <br>
        <div class="d-grid">
            <div class="row">
                @if ($cek_ujian == 0)
                    <div class="col-lg-6 col-12">
                        <button type="button" class="btn btn-dark w-100">
                            <i data-feather="refresh-cw" class="me-25"></i>
                            <span>Tutup</span>
                        </button>
                    </div>
                @else
                    <div class="col-lg-6 col-12">
                        @if ($sudah_ujian == 0)
                            <button type="button" class="btn btn-primary w-100"
                                onclick="location.href='/pengampu/sketsa-murojaah/ujian/'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit">
                                    <path
                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                    </path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                    </path>
                                </svg>
                                <span>Ujian</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-success w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-check-circle">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <span>Selesai</span>
                            </button>
                        @endif
                    </div>
                @endif
                <div class="d-lg-none d-xl-none mb-1"></div>
                <div class="col-lg-6 col-12">
                    <button type="button" class="btn btn-outline-primary w-100"
                        onclick="location.href='/pengampu/sketsa-murojaah/detail/{{ $nis }}'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-list">
                            <line x1="8" y1="6" x2="21" y2="6">
                            </line>
                            <line x1="8" y1="12" x2="21" y2="12">
                            </line>
                            <line x1="8" y1="18" x2="21" y2="18">
                            </line>
                            <line x1="3" y1="6" x2="3.01" y2="6">
                            </line>
                            <line x1="3" y1="12" x2="3.01" y2="12">
                            </line>
                            <line x1="3" y1="18" x2="3.01" y2="18">
                            </line>
                        </svg>
                        <span>Detail</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
