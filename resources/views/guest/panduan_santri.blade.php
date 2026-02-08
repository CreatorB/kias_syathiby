@extends('layouts.landing.page')

@section('content')
<!--Judul Halaman-->
<section class="page-title overflow-hidden position-relative" data-bg-color="#fbf3ed">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-12">
          <h1 class="title"><span>P</span>anduan Santri</h1>
          <p>Informasi penting bagi anda yang ingin menjadi santri Takhassus Al Barkah</p>
        </div>
        <div class="col-lg-5 col-md-12 text-lg-end mt-3 mt-lg-0">
          <nav aria-label="breadcrumb" class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Panduan Santri</li>
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
        <h2 class="title z-index-1 mb-2">Tujuan</h2>
        <p class="lead mb-3 text-black">
            Panduan ini dibuat dengan tujuan memudahkan santri dalam mengikuti pembelajaran di Lembaga Pendidikan Takhassus Al Barkah
        </p>

        <h2 class="title z-index-1 mb-2">Santri</h2>
        <p class="lead mb-3 text-black">
            Santri adalah mereka yang telah dinyatakan lulus sebagai peserta dan telah memenuhi persyaratan administrasi.
        </p>

        <h2 class="title z-index-1 mb-2">Kegiatan Belajar</h2>
        <p class="lead mb-3 text-black">
            Selama KBM peserta mengikuti perkuliahan dengan sungguh-sungguh dan mengerjakan tugas-tugas di luar KBM dengan penuh tanggung jawab.
        </p>

        <h2 class="title z-index-1 mb-2">Penampilan</h2>
        <p class="lead mb-3 text-black">
            Peserta berpenampilan sopan dan sesuai ketentuan syariat (dalam berpakaian dan bertutur kata).
        </p>

        <h2 class="title z-index-1 mb-2">Kehadiran</h2>
        <p class="lead mb-3 text-black">
            Peserta diwajibkan mengikuti perkuliahan tatap muka <b>minimal 60% kehadiran.</b><br>
            Peserta dapat menginformasikan izin tidak mengikuti perkuliahan via wa/telepon ke admin takhassus.
        </p>

        <h2 class="title z-index-1 mb-2">Jam Belajar</h2>
        <p class="lead mb-3 text-black">
            Santri dan ustadz hadir sebelum jam pelajaran dimulai.
        </p>

        <h2 class="title z-index-1 mb-2">Ujian</h2>
        <p class="lead mb-3 text-black">
            1. Peserta diwajibkan mengikuti ujian harian (termasuk tugas-tugas), ujian tengah semester, dan ujian akhir semester. <br>
            2. Hasil ujian dalam dituangkan dalam bentuk transkrip nilai.
        </p>

        <h2 class="title z-index-1 mb-2">Surat Keterangan Santri</h2>
        <p class="lead mb-3 text-black">
            Peserta yang membutuhkan surat keterangan santri, dipersilakan mengisi link surat keterangan santri, lalu konfirmasi ke kontak admin untuk segera dibuatkan suratnya
        </p>

        <h2 class="title z-index-1 mb-2">Mutasi Program</h2>
        <p class="lead mb-3 text-black">
            Peserta yang hendak melakukan mutasi program/jenjang, dipersilakan mengisi link mutasi program, lalu konfirmasi ke kontak admin untuk didata.
        </p>

        <h2 class="title z-index-1 mb-2">Cuti/Berhenti</h2>
        <p class="lead mb-3 text-black">
            1. Peserta yang hendak cuti/ berhenti mengikuti perkuliahan mengisi form cuti/berhenti.<br>
            2. Form Cuti berhenti diisi dengan menggunakan link Cuti/Berhenti. lalu konfirmasi ke kontak admin untuk didata.
        </p>

        <h2 class="title z-index-1 mb-2">Transkrip Nilai</h2>
        <p class="lead mb-3 text-black">
            1. Seluruh peserta mendapatkan hasil penilaian dalam bentuk transkrip nilai. Transkrip nilai merupakan gambaran umum kompetensi santri dalam setiap mata kuliah. <br>
            2. Transkrip nilai diambil di idaroh pada biro dministrasi akademik. Jika terjadi kesalahan nilai pada transkrip nilai maka peserta menghubungi ustadz untuk perbaikan nilai.<br>
            3. Setelah perbaikan nilai maka peserta menginformasikan perbaikan nilai ke idaroh biro administrasi akademik untuk mendapatkan transkrip nilai yang baru.
        </p>

        <h2 class="title z-index-1 mb-2">Ijazah</h2>
        <p class="lead mb-3 text-black">
            Peserta yang membutuhkan Ijazah, dipersilakan mengisi link Data Ijazah Santri santri, lalu konfirmasi ke kontak admin untuk segera dibuatkan Ijazahnya.
        </p>

        <h2 class="title z-index-1 mb-2">Lain - Lain</h2>
        <p class="lead mb-3 text-black">
            Peserta/Santri Takhassus yang berkehendak menghadiahkan/menghibahkan barang berupa VCD, buku bacaan, Al-Quran atau barang lainnya berupa media/sarana untuk berdakwah; <br>
            maka Santri Takhassus tidak diperkenankan membagikan barang tersebut langsung kepada santri takhassus tapi hendaklah menyampaikan barang-barang tersebut terlebih dahulu ke pihak management takhassus untuk diproses dan mendapatkan izin.
        </p>

        </div>
    </div>
    </div>
</div>
<!--#Page Content-->
@endsection
