<!--footer start-->
<footer class="footer position-relative" data-bg-img="{{ asset('landing/images/bg/05.png') }}">
  <!-- Part Of Section -->
  <div class="footer-partners py-4">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 text-center mb-3">
          <span class="part-of-text">A Part Of</span>
        </div>
        <div class="col-12">
          <div class="partner-logos d-flex flex-wrap justify-content-center align-items-center gap-3 gap-md-4">
            <a href="https://www.instagram.com/yayasancahayasunnah" target="_blank" class="partner-logo" title="Yayasan Cahaya Sunnah">
              <img src="{{ asset('landing/images/partners/yayasancahayasunnah.jpg') }}" alt="Yayasan Cahaya Sunnah"
                class="img-fluid"
                style="max-height: 45px; opacity: 0.9; transition: all 0.3s ease;">
            </a>
            <a href="https://www.radiorodja.com" target="_blank" class="partner-logo" title="Rodja">
              <img src="{{ asset('landing/images/partners/rodja.png') }}" alt="Rodja" class="img-fluid"
                style="max-height: 45px; opacity: 0.9; transition: all 0.3s ease;">
            </a>
            <a href="https://syathiby.id" target="_blank" class="partner-logo" title="Ma'had Syathiby">
              <img src="{{ asset('landing/images/partners/syathiby.webp') }}" alt="Ma'had Syathiby" class="img-fluid"
                style="max-height: 45px; opacity: 0.9; transition: all 0.3s ease;">
            </a>
            <a href="https://syathiby.id" target="_blank" class="partner-logo" title="Ma'had Aly Syathiby">
              <img src="{{ asset('landing/images/partners/mahadalysyathiby.png') }}" alt="Ma'had Aly Syathiby" class="img-fluid"
                style="max-height: 45px; opacity: 0.9; transition: all 0.3s ease;">
            </a>
            <a href="https://www.instagram.com/masjidalbarkahcileungsi" target="_blank" class="partner-logo" title="Masjid Jami' Al-Barkah">
              <img src="{{ asset('landing/images/partners/masjidalbarkah.png') }}" alt="Masjid Jami' Al-Barkah" class="img-fluid"
                style="max-height: 45px; opacity: 0.9; transition: all 0.3s ease;">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Secondary Footer -->
  <div class="secondary-footer">
    <div class="container">
      <div class="copyright">
        <div class="row align-items-center">
          <!-- Copyright -->
          <div class="col-lg-4 col-md-12 text-center text-lg-start mb-3 mb-lg-0">
            <span>&copy; Copyright {{ date('Y') }} - <a href="https://kias-syathiby.id">KIAS</a></span>
          </div>
          <!-- Social Media Icons -->
          <div class="col-lg-4 col-md-12 text-center mb-3 mb-lg-0">
            <div class="footer-social-icons">
              <a href="https://www.instagram.com/kias_syathiby/" target="_blank" class="social-icon"
                title="Instagram">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="https://www.facebook.com/kias_syathiby" target="_blank" class="social-icon" title="Facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://www.youtube.com/@kias_syathiby" target="_blank" class="social-icon" title="YouTube">
                <i class="fab fa-youtube"></i>
              </a>
              <a href="https://api.whatsapp.com/send?phone=628111516756" target="_blank" class="social-icon"
                title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
              </a>
            </div>
          </div>
          <!-- Contact Info -->
          <div class="col-lg-4 col-md-12 text-center text-lg-end">
            <span class="contact-info">
              <i class="fab fa-whatsapp me-1"></i> 0811-1516-756
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<style>
  /* Footer Social Icons */
  .footer-social-icons {
    display: flex;
    justify-content: center;
    gap: 15px;
  }

  .footer-social-icons .social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 16px;
    transition: all 0.3s ease;
  }

  .footer-social-icons .social-icon:hover {
    background: #359090;
    transform: translateY(-3px);
  }

  .footer-social-icons .social-icon:hover i {
    color: #fff;
  }

  /* Part Of Text - Elegant Style */
  .part-of-text {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 18px;
    font-weight: 500;
    color: #6c757d;
    letter-spacing: 2px;
    display: inline-block;
    position: relative;
  }

  .part-of-text::before,
  .part-of-text::after {
    content: '';
    display: inline-block;
    width: 40px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #adb5bd, transparent);
    vertical-align: middle;
    margin: 0 15px;
  }

  /* Partner logos hover */
  .partner-logo:hover img {
    opacity: 1 !important;
    transform: scale(1.05);
  }

  /* Contact info styling */
  .contact-info {
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
  }

  /* Mobile responsive */
  @media (max-width: 767px) {
    .footer-partners {
      padding: 20px 0 !important;
    }

    .partner-logos {
      gap: 15px !important;
    }

    .partner-logo img {
      max-height: 35px !important;
    }

    .footer-social-icons .social-icon {
      width: 35px;
      height: 35px;
      font-size: 14px;
    }

    .secondary-footer .copyright {
      padding: 15px 0;
    }
  }
</style>
<!--footer end-->

@include('layouts.partials.credit')
