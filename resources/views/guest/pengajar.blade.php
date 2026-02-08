@extends('layouts.landing.page')

@section('content')
<!--Judul Halaman-->
<section class="page-title overflow-hidden position-relative" data-bg-color="#fbf3ed">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-12">
          <h1 class="title"><span>P</span>engajar</h1>
          <p>Para asatidzah pengajar di setiap program Takhassus Al Barkah</p>
        </div>
        <div class="col-lg-5 col-md-12 text-lg-end mt-3 mt-lg-0">
          <nav aria-label="breadcrumb" class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Pengajar</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <div class="page-title-pattern"><img class="img-fluid" src="{{ asset('landing/images/bg/11.png') }}" alt=""></div>
  </section>
<!--#Judul Halaman-->

<!--Page Content-->
<div class="container">
    <div class="row align-items-center">
    <div class="col-lg-12 col-md-12">
        <div class="team-description">
        <h2 class="title z-index-1 mb-2">Rois Qism</h2>
        <p class="lead mb-3 text-black">
            Berikut ini adalah Rois Qism (Kepala Program) masing-masing :<br>
            1. Al-Barkah Tajwid Al-Qur'an <br>
            <b>Ust. Abu Rif'ah Rifky, Lc.</b><br>
            2. Al-Barkah Bahasa Arab <br>
            <b>Ust. Zahir Alminangkabawi</b><br>
            3. Al-Barkah Takmili <br>
            <b>Ust. Zahir Alminangkabawi</b><br>
            4. Al-Barkah Ulum Asy-Syariah <br>
            <b>Ust. Cecep Nurohman, Lc.MA.</b><br>
            5. Cibinong Tajwid & Bahasa Arab <br>
            <b>Ust. Zaid Al-Khair</b>
        </p>

        <h2 class="title z-index-1 mb-2">Pengajar Setiap Program</h2>
        <div class="accordion ms-lg-5 mt-3" id="accordion">
            <div class="accordion-item border-0 mb-4">
                <h2 class="accordion-header" id="headingSatu">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSatu" aria-expanded="false" aria-controls="collapseSatu">
                    Program Tajwid Al-Qur'an
                    </button>
                </h2>
                <div id="collapseSatu" class="accordion-collapse collapse border-0" aria-labelledby="headingSatu" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        @foreach ($pengajar_tajwid as $item)
                            {{ $item->nama }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 mb-4">
                <h2 class="accordion-header" id="headingDua">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDua" aria-expanded="false" aria-controls="collapseDua">
                    Program Bahasa Arab
                    </button>
                </h2>
                <div id="collapseDua" class="accordion-collapse collapse border-0" aria-labelledby="headingDua" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        @foreach ($pengajar_bahasa as $item)
                            {{ $item->nama }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 mb-4">
                <h2 class="accordion-header" id="headingTiga">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTiga" aria-expanded="false" aria-controls="collapseTiga">
                    Program Takmili
                    </button>
                </h2>
                <div id="collapseTiga" class="accordion-collapse collapse border-0" aria-labelledby="headingTiga" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        @foreach ($pengajar_takmili as $item)
                            {{ $item->nama }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="accordion-item border-0 mb-4">
                <h2 class="accordion-header" id="headingEmpat">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEmpat" aria-expanded="false" aria-controls="collapseEmpat">
                    Program Ulum Asy-Syariah
                    </button>
                </h2>
                <div id="collapseEmpat" class="accordion-collapse collapse border-0" aria-labelledby="headingEmpat" data-bs-parent="#accordion">
                    <div class="accordion-body">
                        @foreach ($pengajar_syariah as $item)
                            {{ $item->nama }}<br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
    </div>
</div>
<!--#Page Content-->
@endsection
