<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <span>{{ $judul }}</span>
            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                @isset($sub_judul)
                    {{ $sub_judul }}
                @endisset
            </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end mt-1 pt-25">
            <div class="role-heading">
                <h4 class="fw-bolder">{{ $konten }}</h4>
                <small class="fw-bolder">{{ $sub_konten }}</small>
            </div>
            {{ $slot }}
            {{-- <a href="javascript:void(0);" class="text-body"><i data-feather="copy"
                    class="font-medium-5"></i></a> --}}
        </div>
    </div>
</div>
