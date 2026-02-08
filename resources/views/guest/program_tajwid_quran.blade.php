@extends('layouts.landing.page')

@section('content')
    <!--Judul Halaman-->
    <section class="page-title overflow-hidden position-relative" data-bg-color="#fbf3ed">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12">
                    <h1 class="title"><span>T</span>ajwid Al-Qur'an</h1>
                    <p>Program untuk anda yang ingin bisa membaca dan menulis Al-Qur'an</p>
                </div>
                <div class="col-lg-5 col-md-12 text-lg-end mt-3 mt-lg-0">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Program Tajwid Al-Qur'an</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="page-title-pattern"><img class="img-fluid" src="{{ asset('landing/images/bg/11.png') }}" alt="">
        </div>
    </section>
    <!--#Judul Halaman-->

    <!--Page Content-->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 mt-3 mt-lg-0">
                <div class="team-description">
                    <h2 class="title z-index-1 mb-2">Muqoddimah</h2>
                    <p class="lead mb-3 text-black">
                        Allah Subhanahu wa Ta’ala berfirman: “Orang-orang yang telah Kami beri Kitab, mereka membacanya
                        sebagaimana mestinya, mereka itulah orang yang beriman kepadanya..” <b>(QS al-Baqarah: 121)</b> <br>
                        “Sebaik-baik kalian adalah yang belajar Al-Quran dan yang mengajarkannya.” <b>(HR. al-Bukhori, dari
                            Utsman bin Affan)</b> <br>
                        “Orang yang mahir membaca (dan menghafal) al-Quran bersama para malaikat yang mulia lagi taat (pada
                        hari kiamat). Orang yang membaca al-Quran dengan terbata-bata lagi sulit (dalam membacanya)
                        mendapatkan 2 pahala.” <b>(HR. Muslim)</b> <br>
                        Membaca al-Quran tidak seperti membaca kitab-kitab lain buatan manusia. Membaca al-Quran harus
                        sesuai dengan yang diperintahkan Allah dan dicontohkan oleh Rasul-Nya.
                        Allah berfirman: “… dan bacalah al-Quran itu dengan perlahan-lahan.”
                        <b>(QS.al-Muzamil:4)</b><br><br>
                        Al-Imam Ibnul Jajari <em>rohimahulahu</em> mengatakan:<br>
                        “Membaca al-Quran dengan tajwid hukumnya wajib barang siapa yang membacanya tidak dengan tajwid ia
                        berdosa karena dengan tajwidlah Allah menurunkan al-Quran dan demikian pula al-Quran sampai kepada
                        kita.”<br><br>
                        Berdasarkan dalil di atas, kaum muslimin diwajibkan membaca al-Quran dengan tajwid. Maka ilmu tajwid
                        merupakan ilmu yang sangat penting dipelajari oleh kaum muslimin dan cara terbaik yaitu dengan
                        berguru kepada seorang yang ahli, sebagaimana Rasulullah shalalllahu alaihi wa salam pun langsung
                        diajarkan oleh malaikat Jibril alaihi salam.
                    </p>

                    <h2 class="title z-index-1 mb-2">Standar Kompetensi Lulusan</h2>
                    <p class="lead mb-3 text-black">
                        Setelah menyelesaikan pendidikan Tajwid Al-Quran selama 1 Tahun di Lembaga Pendidikan Takhassus
                        diharapkan para santri <b>memiliki kemampuan membaca dan menulis Al Quran dengan baik dan
                            benar.</b><br><br>
                        Setelah mengikuti proses pendidikan dengan benar maka para santri diharapkan memiliki
                        kompetensi:<br>
                        1. Mampu membaca dan menulis Al-Quran dengan baik dan benar<br>
                        2. Memiliki dasar-dasar Ilmu Tajwid<br>
                        3. Mengenal nilai-nilai Islam serta mampu mempraktekannya dalam kehidupan<br>
                        4. Memiliki akhlak yang mulia<br>
                    </p>

                    <h2 class="title z-index-1 mb-2">Peserta</h2>
                    <p class="lead mb-3 text-black">
                        Santri Tajwid Al-Quran adalah: <br>
                        1. Ikhwan dan Akhwat yang belum bisa baca dan tulis Al-Quran. <br>
                        2. Ikhwan dan Akhwat yang sudah bisa baca tulis Al-Quran namun ingin mempelajar ilmu Tajwid. <br>
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
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $item->id }}" aria-expanded="false"
                                        aria-controls="collapse{{ $item->id }}">
                                        {{ $item->nama_program }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $item->id }}" class="accordion-collapse collapse border-0"
                                    aria-labelledby="heading{{ $item->id }}" data-bs-parent="#accordion">
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
