# KIAS (Kursus Ilmu Bahasa Arab dan Syar'i) - New Student Registration System

A web-based information system designed to manage the New Student Admission (PSB) process for **KIAS (Kursus Ilmu Bahasa Arab dan Syar'i)**. 

> **Note:** This project is a rebranding and evolution of the **[Takhassus Al Barkah](https://github.com/alendiasetiawan/takhassus-albarkah)** system.

This application includes features such as online registration, payment verification, student data management, and enrollment statistics.

## 🎨 Color Palette

### Gradient KIAS 1
| Color | Hex Code |
| :---: | :---: |
| ![#f1f1f1](https://via.placeholder.com/20/f1f1f1/f1f1f1.png) Light Gray | `#f1f1f1` |
| ![#359090](https://via.placeholder.com/20/359090/359090.png) Teal (Primary) | `#359090` |

### Gradient KIAS 2
| Color | Hex Code |
| :---: | :---: |
| ![#267084](https://via.placeholder.com/20/267084/267084.png) Dark Teal | `#267084` |
| ![#3a9b94](https://via.placeholder.com/20/3a9b94/3a9b94.png) Medium Teal | `#3a9b94` |
| ![#8dc794](https://via.placeholder.com/20/8dc794/8dc794.png) Light Green | `#8dc794` |

### CSS Variables
```css
:root {
  /* Primary Colors */
  --kias-primary: #359090;
  --kias-secondary: #267084;
  --kias-accent: #3a9b94;
  --kias-highlight: #8dc794;
  --kias-light: #f1f1f1;

  /* Gradients */
  --kias-gradient-1: linear-gradient(135deg, #f1f1f1 0%, #359090 100%);
  --kias-gradient-2: linear-gradient(135deg, #267084 0%, #3a9b94 50%, #8dc794 100%);
}
```

---

## 🚀 Key Features

### 1. **Multi-Role User**
- **Administrator**:
  - Comprehensive statistical dashboard (Total Students, Male/Female ratios, Payment Status).
  - Registration management (Transfer Verification).
  - Master Student Data management with advanced filtering (Gender/Program).
  - Data Export/Import capabilities.
- **Student (Calon Santri)**:
  - Online registration form.
  - Required document uploads.
  - Registration status & acceptance check.

### 2. **Registration Module**
- Automated data validation.
- Proof of payment upload.
- Manual/Automatic verification by administrators.

### 3. **Data Management**
- Filter students by **Gender** (Ikhwan/Akhwat).
- Filter students by **Educational Program**.
- Real-time student search (powered by Livewire).

---

## 🛠️ Technology Stack

- **Backend Framework**: [Laravel 10.x](https://laravel.com)
- **Frontend Interactivity**: [Livewire 3.x](https://livewire.laravel.com)
- **UI Framework**: Bootstrap 5 (Vuexy Admin Template)
- **Database**: MySQL
- **Authentication**: Laravel Standard Auth + Role-based middleware.
- **Other Packages**:
  - `barryvdh/laravel-debugbar`: Debugging tools.
  - `mobiledetect/mobiledetectlib`: User device detection.

---

## ⚙️ System Requirements

Ensure your local development environment meets the following requirements (highly recommended to use **Laragon**):
- PHP >= 8.1
- Composer
- MySQL Database

---

## 📥 Installation Guide (Local Development)

Follow these steps to run the project on your local machine:

### 1. Clone Repository
```bash
git clone git@github.com:CreatorB/kias_syathiby.git
cd kias
```

### 2. Install Dependencies
Install PHP libraries using Composer:
```bash
composer install
```

### 3. Environment Configuration
Duplicate the `.env.example` file to `.env`:
```bash
cp .env.example .env
```
Open the `.env` file and configure your database settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kias
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database
Ensure the `kias` database is created in MySQL, then run migrations:
```bash
php artisan migrate --seed
```
*(Note: If `--seed` does not populate users, use the credentials below)*

### 6. Run Server
If using Laragon, simply start Laragon and open `http://kias.test`.
If using the built-in server:
```bash
php artisan serve
```
Access at `http://localhost:8000`.

---

## 🔑 Demo Accounts (Default Credentials)

Use the following accounts to log in and test the system:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@localhost.com` | `password` |
| **Student (Santri)** | `santri@localhost.com` | `password` |

---

## 📂 Key Directory Structure

- `app/Http/Controllers`: Standard backend logic.
- `app/Livewire`: Interactive components (Data Santri, Dashboard).
- `app/Models`: Database models (Santri, User, Program).
- `resources/views/layouts`: Main templates (Sidebar, Header).
- `resources/views/livewire`: Livewire component views.
- `public/berkas`: Storage location for student uploads (Ignored by Git).

---

## 🔒 Security

- This project is configured with a secure `.gitignore`.
- Sensitive files such as `.env`, `vendor` folder, and user upload data (`public/berkas`) are **NOT** included in the repository.

---

## 📝 Developer Notes
- The main layout is located at `resources/views/layouts/app.blade.php`.
- The admin navigation menu can be edited at `resources/views/layouts/sidebars/admin_sidebar.blade.php`.
- To modify student data filtering logic, checked `App\Livewire\Admin\Pendaftaran\DataSantri.php`.

---

## 🚀 Deployment / Update Guide (Existing Server)

Panduan untuk deploy atau update ke server yang sudah ada (tanpa menghapus data lama).

### 1. Pull Latest Code
```bash
cd /path/to/kias
git pull origin main
```

### 2. Install/Update Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 3. Create Required Directories
Buat folder yang diperlukan untuk upload file (jika belum ada):
```bash
# Linux/MacOS
mkdir -p public/berkas/events/images
mkdir -p public/berkas/events/certificates
mkdir -p public/berkas/events/payments
mkdir -p public/berkas/santri
mkdir -p public/berkas/bukti_transfer

# Set permissions (Linux/MacOS)
chmod -R 755 public/berkas
chown -R www-data:www-data public/berkas

# Windows (PowerShell)
New-Item -ItemType Directory -Force -Path "public\berkas\events\images"
New-Item -ItemType Directory -Force -Path "public\berkas\events\certificates"
New-Item -ItemType Directory -Force -Path "public\berkas\events\payments"
New-Item -ItemType Directory -Force -Path "public\berkas\santri"
New-Item -ItemType Directory -Force -Path "public\berkas\bukti_transfer"
```

### 4. Run Migrations
**PENTING:** Gunakan `--force` untuk production environment.
```bash
php artisan migrate --force
```

Migrations yang akan dijalankan (update terbaru):
- `2024_01_01_000001_create_roles_table` - Tabel roles
- `2024_01_01_000002_add_role_id_to_users_table` - Relasi user ke role
- `2024_01_01_000003_create_events_table` - Tabel events
- `2024_01_01_000004_create_event_registrations_table` - Pendaftaran event
- `2024_01_01_000005_create_event_attendances_table` - Absensi event
- `2024_01_01_000006_add_images_to_events_table` - Multiple images
- `2024_01_01_000007_add_missing_fields_to_users_table` - Field user
- `2024_01_01_000008_add_registration_dates_and_groups_to_events_table` - Periode pendaftaran & grup WA
- `2024_01_01_000009_add_quota_to_events_table` - Kuota peserta
- `2024_01_01_000010_add_auto_accept_to_events_table` - Auto accept pendaftar

### 5. Clear & Optimize Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6. Restart Queue Worker (if applicable)
```bash
php artisan queue:restart
```

---

## 📋 Events Management Features

### Fitur Event Admin
- **CRUD Events** - Create, Read, Update, Delete event
- **Multiple Images** - Upload hingga 5 gambar per event
- **Periode Pendaftaran** - Set tanggal buka/tutup pendaftaran
- **Grup WhatsApp** - Link grup terpisah untuk Ikhwan, Akhwat, dan Umum
- **Kuota Peserta** - Batasi jumlah peserta per jenis kelamin
- **Auto Accept** - Pendaftar otomatis dikonfirmasi atau manual review
- **Fitur Sertifikat** - Generate sertifikat dengan template custom
- **Fitur Absensi** - Peserta bisa absen saat event berlangsung

### Fitur Event User
- **Pendaftaran Event** - Daftar event dengan/tanpa login
- **Status Pendaftaran** - Lihat status (pending/valid/invalid)
- **Absensi** - Klik tombol hadir saat event berlangsung
- **Download Sertifikat** - Setelah absen, bisa download sertifikat
- **Link Grup** - Akses grup WA sesuai jenis kelamin

### Alur Pendaftaran Event
1. User melihat list event di `/events`
2. User klik event untuk melihat detail
3. Jika belum login, user bisa daftar sekaligus membuat akun
4. Jika sudah login, form akan auto-fill data user
5. Upload bukti bayar (jika event berbayar)
6. Admin konfirmasi pembayaran (atau auto-accept jika diaktifkan)
7. Saat event berlangsung, user bisa absen dari dashboard
8. Setelah absen, user bisa download sertifikat (jika tersedia)

---

## 🗄️ Database Schema (Events)

### events
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| slug | varchar | URL-friendly identifier |
| title | varchar | Judul event |
| content | text | Deskripsi (HTML) |
| image | varchar | Legacy single image |
| images | json | Array of image filenames |
| start_date | datetime | Waktu mulai event |
| end_date | datetime | Waktu selesai event |
| registration_start | datetime | Waktu buka pendaftaran |
| registration_end | datetime | Waktu tutup pendaftaran |
| is_paid | boolean | Event berbayar? |
| price | decimal | Harga (jika berbayar) |
| has_attendance | boolean | Fitur absensi aktif? |
| has_certificate | boolean | Fitur sertifikat aktif? |
| certificate_template | varchar | File template sertifikat |
| certificate_font | varchar | Font untuk nama |
| certificate_font_color | varchar | Warna font |
| certificate_font_size | int | Ukuran font |
| certificate_name_x | int | Posisi X nama |
| certificate_name_y | int | Posisi Y nama |
| status | enum | draft/published/closed |
| group_ikhwan | varchar | Link grup Ikhwan |
| group_akhwat | varchar | Link grup Akhwat |
| group_public | varchar | Link grup umum |
| quota_ikhwan | int | Kuota peserta Ikhwan |
| quota_akhwat | int | Kuota peserta Akhwat |
| auto_accept | boolean | Auto konfirmasi pendaftar? |

### event_registrations
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| event_id | bigint | FK ke events |
| user_id | bigint | FK ke users |
| name | varchar | Nama peserta |
| phone | varchar | Nomor HP |
| email | varchar | Email |
| address | text | Alamat |
| gender | varchar | L/P |
| birth_place | varchar | Tempat lahir |
| birth_date | date | Tanggal lahir |
| occupation | varchar | Pekerjaan |
| payment_proof | varchar | File bukti bayar |
| payment_status | enum | pending/valid/invalid |
| registered_at | datetime | Waktu daftar |

### event_attendances
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| event_registration_id | bigint | FK ke registrations |
| attended_at | datetime | Waktu absen |

---

## 🔧 Troubleshooting

### Error: "SQLSTATE[42S22]: Column not found"
Jalankan migrations:
```bash
php artisan migrate --force
```

### Error: "The directory does not exist"
Buat folder yang diperlukan:
```bash
mkdir -p public/berkas/events/images
mkdir -p public/berkas/events/certificates
mkdir -p public/berkas/events/payments
```

### Error: "Permission denied"
Set permissions:
```bash
chmod -R 755 public/berkas
chown -R www-data:www-data public/berkas
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### Cache Issues
Clear semua cache:
```bash
php artisan optimize:clear
```

---

Copyright creatorbe ITS Syathiby 2024 © 2026 **KIAS (Kursus Ilmu Bahasa Arab dan Syar'i)**.
