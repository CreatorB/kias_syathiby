<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Afwan - Halaman Tidak Ditemukan | KIAS</title>
    <link rel="shortcut icon" href="{{ asset('landing/images/takhassus-icon.ico') }}" />
    <link href="{{ asset('landing/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a4d4d 0%, #0d2626 100%);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            padding: 20px;
        }

        .error-container {
            text-align: center;
            max-width: 400px;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 700;
            color: rgba(255,255,255,0.15);
            line-height: 1;
            margin-bottom: 10px;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 2.5rem;
            color: #d4af37;
            margin-bottom: 5px;
        }

        .afwan-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.8);
            margin-bottom: 25px;
        }

        .btn-group-custom {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-home, .btn-wa {
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s ease;
        }

        .btn-home {
            background: linear-gradient(135deg, #d4af37 0%, #b8962d 100%);
            color: #1a4d4d;
        }

        .btn-wa {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: #ffffff;
        }

        .btn-home:hover, .btn-wa:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 400px) {
            .error-code { font-size: 4rem; }
            .arabic-text { font-size: 2rem; }
            .btn-group-custom { flex-direction: column; }
            .btn-home, .btn-wa { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="arabic-text">عفوًا</div>
        <h1 class="afwan-text">Afwan</h1>
        <p class="error-message">Halaman tidak ditemukan</p>
        <div class="btn-group-custom">
            <a href="/" class="btn-home">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="#" class="btn-wa" id="waButton">
                <i class="fab fa-whatsapp"></i> Hubungi Kami
            </a>
        </div>
    </div>

    <script>
        document.getElementById('waButton').addEventListener('click', function(e) {
            e.preventDefault();
            var currentUrl = window.location.href;
            var message = encodeURIComponent("Assalamu'alaikum, mau tanya kenapa halaman: " + currentUrl + " tidak bisa diakses?");
            var waNumber = "628111516756";
            window.open("https://wa.me/" + waNumber + "?text=" + message, "_blank");
        });
    </script>
</body>

</html>
