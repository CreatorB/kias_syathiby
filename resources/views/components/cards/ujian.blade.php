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
                <p class="card-text mb-0">{{ $data->program }} | {{ $data->detail_kelas }}</p>
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
                {{ $button_action }}
            </div>
        </div>
    </div>
</div>
