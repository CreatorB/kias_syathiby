@extends('layouts.landing.page')

@section('content')
<!--Judul Halaman-->
<section class="page-title overflow-hidden position-relative" data-bg-color="#fbf3ed">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-12">
          <h1 class="title"><span>T</span>akmili</h1>
          <p>Program lanjutan untuk penyempurnaan bagi anda yang sudah bisa bahasa arab</p>
        </div>
        <div class="col-lg-5 col-md-12 text-lg-end mt-3 mt-lg-0">
          <nav aria-label="breadcrumb" class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Program Takmili</li>
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
        <h2 class="title z-index-1 mb-2">Muqoddimah</h2>
        <p class="lead mb-3 text-black">
            “Bahasa Arab adalah bahasa yang paling fasih dan paling jelas, paling luas dan paling banyak dalam penyampaian makna-maknanya, serta bisa menenangkan jiwa. <br>
            Oleh karena itu diturunkan kitab yang paling mulia (al-Quran) menggunakan bahasa yang mulia(bahasa Arab).” <b>(Ibnu Katsir, Tafsir al-Quran al-Azhim, 2/511)</b> <br>
            Allah Subhanahu wa Ta’ala menurunkan al-Quran dengan bahasa Arab dan mengutus utusan-Nya, Nabi Muhammad <em>Shalallahu ‘alaihi wa sallam’</em> dengan bahasa Arab. Para ulama pembela Sunnah menerangkan al-Quran dan al-Hadits juga dengan bahasa Arab.<br><br>
            Dengan demikian, mempelajari bahasa Arab merupakan bagian dari din (agama).
            Hukum mempelajarinya <b>wajib bagi umat Islam</b> yang mampu dan bertanggung jawab atas tersebarnya Islam di permukaan bumi ini. <br>
            Tidak mungkin untuk memahami dinul-Islam dengan pemahaman yang benar, kecuali dengan bahasa Arab.
        </p>

        <h2 class="title z-index-1 mb-2">Standar Kompetensi Lulusan</h2>
        <p class="lead mb-3 text-black">
            Santri menguasai 4 keterampilan bahasa (mendengar, membaca, berbicara dan menulis) sesuai dengan batas kurikulum yang berlaku
            dengan menekankan pada <b>kemampuan membaca dan mendengar</b> serta dibekali dengan pengetahuan <b>Aqidah, Manhaj dan Fiqih.</b> <br>
            Dengan harapan santri mampu mengikuti jenjang berikutnya yaitu program takhasssus  ilmu syar’i dengan baik.
        </p>

        <h2 class="title z-index-1 mb-2">Peserta</h2>
        <p class="lead mb-3 text-black">
            Santri program takhassus bahasa Arab adalah ikhwan dan akhwat yang sudah memiliki <b>kemampuan dasar bahasa arab</b> dan
            sudah lancar membaca Al-Qur'an atau santri lulusan program Bahasa Arab Takhassus Al Barkah
        </p>

        <h2 class="title z-index-1 mb-2">Kitab Yang Dipelajari</h2>
        <p>
            <ol>
                @foreach ($kitab as $data)
                    <li>{{ $data->nama_kitab }} ({{ $data->penulis }})</li>
                @endforeach
            </ol>
        </p>

        <h2 class="title z-index-1 mb-2">Program Yang Tersedia</h2>
        <div class="accordion ms-lg-5 mt-3" id="accordion">
            @foreach ($program as $item)
                <div class="accordion-item border-0 mb-4">
                    <h2 class="accordion-header" id="heading{{ $item->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapse{{ $item->id }}">
                        {{ $item->nama_program }}
                        </button>
                    </h2>
                    <div id="collapse{{ $item->id }}" class="accordion-collapse collapse border-0" aria-labelledby="heading{{ $item->id }}" data-bs-parent="#accordion">
                        <div class="accordion-body">
                            Persyaratan : {{ $item->persyaratan }}<br>
                            Paket : {{ $item->durasi_belajar }} Tahun<br><br>
                            Hari : {{ $item->hari_belajar }}<br>
                            Waktu : {{ $item->waktu_belajar }}<br>
                            Tempat : {{ $item->tempat_belajar }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
    </div>
</div>
<!--#Page Content-->

<!--Program Lainnya-->
<div class="container mt-3">
    <div class="row">
    <div class="col-lg-12 col-md-12 text-center">
        <h3 class="text-black fw-normal line-h-2">
        Lihat juga program lainnya!
        </h3>
    </div>
    </div>
    <div class="row mt-3">
    <div class="col-lg-4 col-md-6">
        <div class="featured-item style-2">
        <div class="featured-icon">
            <i class="la la-book"></i>
            <span class="rotateme"></span>
            </div>
        <div class="featured-title">
            <h5>Tajwid Al-Qur'an</h5>
        </div>
        <div class="featured-desc">
            <p>Untuk anda yang ingin belajar membaca dan menulis Al-Qur'an dengan lancar</p>
            <a class="icon-btn mt-4" href="/program-tajwid-quran"> <i class="la la-angle-right"></i>
            </a>
        </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-5 mt-md-0">
        <div class="featured-item style-2">
        <div class="featured-icon">
            <i class="la la-book-open"></i>
            <span class="rotateme"></span>
        </div>
        <div class="featured-title">
            <h5>Bahasa Arab</h5>
        </div>
        <div class="featured-desc">
            <p>Belajar bahasa arab intensif dengan fokus pada kemampuan membaca dan mendengar</p>
            <a class="icon-btn mt-4" href="/program-bahasa-arab"> <i class="la la-angle-right"></i>
            </a>
        </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mt-5 mt-md-0">
        <div class="featured-item style-2">
            <div class="featured-icon">
            <i class="la la-school"></i>
            <span class="rotateme"></span>
            </div>
            <div class="featured-title">
            <h5>Ulum Asy-Syariah</h5>
            </div>
            <div class="featured-desc">
            <p>Belajar berbagai macam disiplin ilmu syar'i dengan membaca kitab berbahasa arab</p>
            <a class="icon-btn mt-4" href="/program-ulum-syariah"> <i class="la la-angle-right"></i>
            </a>
            </div>
        </div>
        </div>
    </div>
</div>
<!--#Program Lainnya-->
@endsection
