# KIAS (Kursus Ilmu Bahasa Arab dan Syar'i) - New Student Registration System

A web-based information system designed to manage the New Student Admission (PSB) process for **KIAS (Kursus Ilmu Bahasa Arab dan Syar'i)**. 

> **Note:** This project is a rebranding and evolution of the **![Takhassus Al Barkah](https://github.com/alendiasetiawan/takhassus-albarkah)** system.

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

Copyright creatorbe ITS Syathiby 2024 © 2026 **KIAS (Kursus Ilmu Bahasa Arab dan Syar'i)**.
