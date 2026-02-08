@extends('layouts.landing.page')

@section('content')
<!--Judul Halaman-->
<section class="page-title overflow-hidden position-relative" data-bg-color="#fbf3ed">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-12">
          <h1 class="title"><span>U</span>lum Asy-Syari'ah</h1>
          <p>Program bagi anda yang sudah lancar berbahasa arab dan ingin belajar berbagai disiplin ilmu syar'i</p>
        </div>
        <div class="col-lg-5 col-md-12 text-lg-end mt-3 mt-lg-0">
          <nav aria-label="breadcrumb" class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Program Ulum Asy-Syari'ah</li>
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
            Ilmu yang benar adalah asas utama dalam membangun peradaban dan asas utama menuju perubahan. Ilmu syar’i adalah ilmu yang akan membimbing kita kepada kemuliaan dan kesempurnaan dalam beribadah dan bersimpuh di hadapan Allah Ta’ala. <br>
            Kebutuhan kita terhadap ilmu agama adalah seperti kebutuhan ikan terhadap air. Ia adalah ilmu yang akan menuntun kita meniti jalan menuju kebenaran dan surga. <br><br>
            Baginda Rasulullah <em>shallallahu ‘alaihi wasallam</em> bersabda:<br>
            مَنْ سَلَكَ طَرِيقًا يَلْتَمِسُ فِيهِ عِلْمًا سَهَّلَ اللَّهُ لَهُ بِهِ طَرِيقًا إِلَى الْجَنَّةِ<br>
            “Barangsiapa yang menempuh jalan untuk menuntut ilmu, niscaya Allah  Ta’ala mudahkan baginya jalan menuju surga.”<br><br>
            Menjadi orang yang faham ilmu agama adalah pertanda kebaikan dari Allah Ta’ala, sebab Baginda Rasulullah –shallallahu a’laihi wasallam- bersabda:<br>
            مَنْ يُرِدْ اللَّهُ بِهِ خَيْرًا يُفَقِّهْهُ فِي الدِّينِ <br>
            “Barangsiapa yang Allah kehendaki kebaikan pada dirinya, niscaya Dia akan membuatnya faham (berilmu) tentang urusan agama ini.”<br><br>
            Fakta bahwa banyak kaum muslimin yang belum memahami agama ini dengan benar, mengharuskan kita untuk turun ambil bagian memperlajari ilmu islam yang murni itu.
            Sebab, menuntut ilmu agama adalah kewajiban. Allah berfirman: <br>
            وَمَا كَانَ الْمُؤْمِنُونَ لِيَنْفِرُوا كَافَّةً فَلَوْلَا نَفَرَ مِنْ كُلِّ فِرْقَةٍ مِنْهُمْ طَائِفَةٌ لِيَتَفَقَّهُوا فِي الدِّينِ وَلِيُنْذِرُوا قَوْمَهُمْ إِذَا رَجَعُوا إِلَيْهِمْ لَعَلَّهُمْ يَحْذَرُونَ <br>
            “Tidak sepatutnya bagi orang-orang yang mu’min itu pergi semuanya (ke medan perang).
            Mengapa tidak pergi dari tiap-tiap golongan diantara mereka beberapa orang untuk memperdalam pengetahuan mereka tentang agama dan untuk member peringatan kepada kaumnya apabila mereka telah kembali kepadanya,
            supaya mereka itu dapat menjaga dirinya.”
        </p>

        <h2 class="title z-index-1 mb-2">Standar Kompetensi Lulusan</h2>
        <p class="lead mb-3 text-black">
            Setelah mengikuti proses pendidikan dengan benar maka para santri diharapkan: <br>
            1. Mampu membaca kitab para ulama  yang berbahasa Arab <br>
            2. Memiliki dasar-dasar Ulumu As-Syari’ah <br>
            3. Memiliki dasar-dasar Ulumu Al-Hadits <br>
            4. Mengetahui sumber rujukan kitab dengan ilmiah <br>
            5. Mengetahui  dasar-dasar pengambilan hukum dengan shohih <br>
            6. Mampu mengamalkan ilmu yang diambil dari rujukan kitab yang shohih dengan pengamalan yang shahih <br>
            7. Mampu mendakwahkan ilmu dengan shohih <br>
            8. Mengenal nilai-nilai islam serta mampu mempraktekannya dalam kehidupan <br>
            9. Memiliki akhlak yang mulia. <br>
        </p>

        <h2 class="title z-index-1 mb-2">Peserta</h2>
        <p class="lead mb-3 text-black">
            Santri Takhossus Ulumu As-Syariah disyaratkan mempunyai <b>kemampuan Bahasa Arab dasar baik aktif maupun pasif yang memadai</b>,
            karena proses belajar mengajar menggunakan bahasa Arab.
        </p>

        <h2 class="title z-index-1 mb-2">Kitab Yang Dipelajari</h2>
        @foreach ($kitab as $data => $value)
        <strong>Kelas {{ $data }}</strong>
        <ol>
            @foreach ($value as $item)
                <li>{{ $item->nama_kitab }} ({{ $item->penulis }})</li>
            @endforeach
        </ol>
        @endforeach

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
            <i class="la la-pen-nib"></i>
            <span class="rotateme"></span>
            </div>
            <div class="featured-title">
            <h5>Takmili</h5>
            </div>
            <div class="featured-desc">
            <p>Program penyempurnaan bagi anda yang sudah pernah belajar bahasa arab</p>
            <a class="icon-btn mt-4" href="/program-takmili"> <i class="la la-angle-right"></i>
            </a>
            </div>
        </div>
        </div>
    </div>
</div>
<!--#Program Lainnya-->
@endsection
