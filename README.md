# KIAS (Kursus Ilmu Bahasa Arab dan Syar'i) Syathiby

A web-based information system designed to manage the process for **KIAS (Kursus Ilmu Bahasa Arab dan Syar'i)**.

> **Note:** This project is a rebranding and evolution of the **[Takhassus Al Barkah](https://github.com/alendiasetiawan/takhassus-albarkah)** system.

This application includes features such as online registration, payment verification, student data management, event management, account settings, and enrollment statistics.

## Color Palette

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

## Key Features

### 1. Multi-Role User System

| Role | ID | Description |
|------|----|-------------|
| **Superadmin** | 1 | Full access including permission management |
| **Admin** | 2 | Dashboard, registrations, student data, event management |
| **Santri** | 3 | Student role with profile and event access |
| **Peserta** | 4 | Participant role for event registration and attendance |

### 2. Authentication
- Login using **Email** or **Phone Number**.
- Phone number normalization supports formats: `08xx`, `+628xx`, `628xx`.
- **Passwordless login** for Peserta (participants) registered in a same-day event — designed for easy attendance check-in during daurah.

### 3. Account Settings (`/pengaturan`)
All authenticated users can manage their own account:
- **Update Profile** — Full name, email, phone, gender, birth place/date, occupation, address.
- **Change Password** — Requires current password verification, minimum 8 characters.

### 4. Registration Module
- Automated data validation.
- Proof of payment upload.
- Manual/Automatic verification by administrators.

### 5. Student Data Management
- Filter students by **Gender** (Ikhwan/Akhwat).
- Filter students by **Educational Program**.
- Real-time student search (powered by Livewire).

### 6. Permission Management (Superadmin)
- Role-based permission system with `permissions` and `role_permissions` tables.
- Superadmin can assign/revoke granular permissions per role via `/admin/settings/permissions`.
- Superadmin automatically has all permissions.

---

## Events Management

### Admin Event Features
- **CRUD Events** — Create, Read, Update, Delete events.
- **Multiple Images** — Upload up to 5 images per event.
- **Registration Period** — Set registration open/close dates.
- **WhatsApp Groups** — Separate group links for Ikhwan (Male), Akhwat (Female), and Public.
- **Participant Quota** — Limit participants by gender.
- **Auto Accept** — Automatically confirm registrations or require manual review.
- **Certificate Feature** — Generate certificates with custom templates.
- **Attendance Feature** — Participants can check-in during the event; exportable to Excel (CSV) and PDF; printable attendance sheets.
- **Internal Events** — Events not publicly listed, accessible only via internal links with unique tokens.
- **Internal Links** — Generate private registration links with per-link quotas and active period.

### Admin Participant Management
- **Manual Add Participant** — Admin can manually add participants to an event (auto-confirmed, increments quota).
- **Edit Participant** — Update name, email, phone, gender, address per participant.
- **Reset Password (Individual)** — Reset a single participant's password to `[REDACTED-LEGACY-PASSWORD]`.
- **Bulk Reset Password** — Reset ALL participants' passwords in an event to `[REDACTED-LEGACY-PASSWORD]` with a single click and confirmation dialog.
- **Confirm/Reject Payment** — Approve or reject payment for pending registrations.
- **Delete Participant** — Remove a participant from the event.
- **Filtering** — Filter participants by search query, payment status, and gender.

### User Event Features
- **Event Registration** — Register for events with or without an existing account.
- **Registration Status** — View status (pending/valid/invalid).
- **Attendance** — Click "Present" button during event.
- **Download Certificate** — Download certificate after attending.
- **Group Links** — Access WhatsApp group based on gender.

### Event Status Types
| Status | Description |
|--------|-------------|
| **Draft** | Event is not visible to anyone, still in preparation |
| **Published** | Event is publicly listed at `/events` and open for registration |
| **Closed** | Event registration is closed |
| **Internal** | Event is NOT publicly listed. Only accessible via internal link (`/events/internal/{slug}/{token}`) |

### Event Registration Flow
1. User views event list at `/events` (published events only)
2. User clicks event to view details
3. If not logged in, user can register and create an account simultaneously
4. If logged in, form auto-fills user data
5. Upload payment proof (if paid event)
6. Admin confirms payment (or auto-accept if enabled)
7. During event, user can check-in (attendance) from dashboard
8. After attendance, user can download certificate (if available)

### Internal Event Flow
1. Admin creates event with status **Internal**
2. Admin creates internal link(s) with quota and active period
3. Admin shares the internal link URL to intended participants
4. Participants access the event via the unique link and register

---

## Technology Stack

- **Backend Framework**: [Laravel 10.x](https://laravel.com)
- **Frontend Interactivity**: [Livewire 3.x](https://livewire.laravel.com)
- **UI Framework**: Bootstrap 5 (Vuexy Admin Template)
- **Database**: MySQL
- **Authentication**: Laravel Standard Auth + Role-based middleware + Passwordless login for event participants
- **Other Packages**:
  - `barryvdh/laravel-debugbar`: Debugging tools.
  - `mobiledetect/mobiledetectlib`: User device detection.

---

## System Requirements

Ensure your local development environment meets the following requirements (highly recommended to use **Laragon**):
- PHP >= 8.1
- Composer
- MySQL Database

---

## Installation Guide (Local Development)

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
or local public
```
php artisan serve --host=0.0.0.0 --port=8000
```

Access at `http://localhost:8000`.

---

## Demo Accounts (Default Credentials)

Use the following accounts to log in and test the system:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@localhost.com` | `password` |
| **Student (Santri)** | `santri@localhost.com` | `password` |

---

## Key Directory Structure

```
app/
  Http/Controllers/       # Standard backend logic
  Livewire/
    Admin/
      Events/             # Event CRUD, Participants, Attendance
      Pendaftaran/        # DataSantri, VerifikasiTransfer, DetailPendaftar
      Settings/           # PermissionManager (superadmin)
    Peserta/              # EventHistory (user dashboard)
    User/                 # Pengaturan (account settings for all users)
  Models/                 # User, Role, Permission, Event, EventRegistration, etc.
  Services/               # EventRegistrationService
resources/views/
  layouts/                # Main templates (app.blade.php, dashboard/, sidebars/, navbars/)
  livewire/               # Livewire component views
  components/             # Blade components (breadcrumb, etc.)
public/berkas/            # Storage for user uploads (ignored by Git)
routes/
  web.php                 # Public + authenticated user routes
  admin.php               # Admin-only routes
```

---

## Security

- This project is configured with a secure `.gitignore`.
- Sensitive files such as `.env`, `vendor` folder, and user upload data (`public/berkas`) are **NOT** included in the repository.

---

## Developer Notes
- The main admin layout is located at `resources/views/layouts/app.blade.php`.
- The dashboard (peserta) layout is at `resources/views/layouts/dashboard/master.blade.php`.
- The admin navigation menu can be edited at `resources/views/layouts/sidebars/admin_sidebar.blade.php`.
- To modify student data filtering logic, check `App\Livewire\Admin\Pendaftaran\DataSantri.php`.
- Account settings for all users: `App\Livewire\User\Pengaturan.php`.

---

## Deployment / Update Guide (Existing Server)

Guide for deploying or updating to an existing server (without deleting old data).

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
Create necessary folders for file uploads (if they don't exist):
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
**IMPORTANT:** Use `--force` for production environment.
```bash
php artisan migrate --force
```

Or use the maintenance route (see Maintenance Routes section below).

Migrations to be run (latest updates):
- `2024_01_01_000001_create_roles_table` — Roles table
- `2024_01_01_000002_add_role_id_to_users_table` — User role relation
- `2024_01_01_000003_create_events_table` — Events table (status: draft/published/closed/internal)
- `2024_01_01_000004_create_event_registrations_table` — Event registrations
- `2024_01_01_000005_create_event_attendances_table` — Event attendance
- `2024_01_01_000006_create_permissions_table` — Permissions and role_permissions tables
- `2024_01_01_000007_add_images_to_events_table` — Multiple images
- `2024_01_01_000008_add_registration_dates_and_groups_to_events_table` — Registration periods & WhatsApp groups
- `2024_01_01_000009_add_quota_to_events_table` — Participant quota
- `2024_01_01_000010_add_auto_accept_to_events_table` — Auto accept registrations
- `2026_02_17_151916_create_event_internal_links_table` — Internal registration links with tokens & quotas
- `2026_02_20_165043_add_internal_status_to_events_table` — Add 'internal' status to events enum

### 5. Clear & Optimize Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Or use the maintenance routes (see section below).

### 6. Restart Queue Worker (if applicable)
```bash
php artisan queue:restart
```

---

## Maintenance Routes

Admin maintenance routes for managing the application without SSH access. All routes require admin authentication.

### Password Protected Routes

These routes require password verification via the `MAINTENANCE_PASSWORD` environment variable. Session lasts for 10 minutes.

| Route | Method | Description |
|-------|--------|-------------|
| `/admin/maintenance/migrate` | GET | Run `php artisan migrate --force` |
| `/admin/maintenance/migrate-refresh` | GET | Rollback and re-run all migrations |
| `/admin/maintenance/optimize` | GET | Run `php artisan optimize` |
| `/admin/maintenance/queue-restart` | GET | Restart queue workers (`queue:restart`) |
| `/admin/maintenance/db-backup` | GET | Download database backup (mysqldump) |

**Setup:**
1. Edit `.env` on production server
2. Set `MAINTENANCE_PASSWORD=your_secure_password_here` (plain text, will be hashed automatically)
3. Access the URL with password:
   ```
   https://yourdomain.com/admin/maintenance/migrate?password=your_secure_password_here
   ```
4. Returns JSON response with command output

**Note:** The password in `.env` should be stored as a bcrypt hash (same format as `APP_KEY`). You can generate a hash using:
```bash
php artisan tinker --execute="echo Hash::make('your_password');"
```

### Public Routes (No Password Required)

These routes perform safe operations that don't modify data.

| Route | Method | Description |
|-------|--------|-------------|
| `/admin/maintenance/clear-all` | GET | Clear cache + config + route + view + optimize |
| `/admin/maintenance/clear-cache` | GET | Clear application cache |
| `/admin/maintenance/clear-view` | GET | Clear compiled views |
| `/admin/maintenance/clear-route` | GET | Clear route cache |
| `/admin/maintenance/clear-config` | GET | Clear config cache |
| `/admin/maintenance/info` | GET | Display system information (PHP, Laravel, DB, etc.) |

### Example: Running Migrations via Browser

1. Ensure you are logged in as admin
2. Set `MAINTENANCE_PASSWORD=your_secure_password` in your `.env` file
3. Access the URL with password:
   ```
   https://yourdomain.com/admin/maintenance/migrate?password=your_secure_password
   ```
4. Returns JSON response with command output

---

## Database Schema

### users
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| nama | varchar | Full name |
| email | varchar | Email (unique) |
| password | varchar | Hashed password |
| role_id | bigint | FK to roles (default: 4) |
| phone | varchar | Phone number |
| address | text | Address |
| gender | enum | Laki-Laki / Perempuan |
| birth_place | varchar | Birth place |
| birth_date | date | Birth date |
| occupation | varchar | Occupation |
| email_verified_at | timestamp | Email verification |
| remember_token | varchar | Remember me token |
| timestamps | | created_at, updated_at |

### roles
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| nama_role | varchar | Role name |

### permissions
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Permission key (e.g., `view_user_photos`) |
| display_name | varchar | Human-readable name |
| group | varchar | Permission group (e.g., `users`, `events`) |
| description | text | Description |

### role_permissions
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| role_id | bigint | FK to roles |
| permission_id | bigint | FK to permissions |

### events
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| slug | varchar | URL-friendly identifier |
| title | varchar | Event title |
| content | text | Description (HTML) |
| image | varchar | Legacy single image |
| images | json | Array of image filenames |
| start_date | datetime | Event start time |
| end_date | datetime | Event end time |
| registration_start | datetime | Registration open time |
| registration_end | datetime | Registration close time |
| is_paid | boolean | Is paid event? |
| price | decimal | Price (if paid) |
| has_attendance | boolean | Attendance feature enabled? |
| has_certificate | boolean | Certificate feature enabled? |
| certificate_template | varchar | Certificate template file |
| certificate_font | varchar | Font for name |
| certificate_font_color | varchar | Font color |
| certificate_font_size | int | Font size |
| certificate_name_x | int | Name X position |
| certificate_name_y | int | Name Y position |
| status | enum | draft/published/closed/internal |
| group_ikhwan | varchar | Ikhwan group link |
| group_akhwat | varchar | Akhwat group link |
| group_public | varchar | Public group link |
| quota_ikhwan | int | Ikhwan quota |
| quota_akhwat | int | Akhwat quota |
| auto_accept | boolean | Auto confirm registration? |

### event_registrations
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| event_id | bigint | FK to events |
| user_id | bigint | FK to users |
| name | varchar | Participant name |
| phone | varchar | Phone number |
| email | varchar | Email |
| address | text | Address |
| gender | varchar | L/P (Gender) |
| birth_place | varchar | Birth place |
| birth_date | date | Birth date |
| occupation | varchar | Occupation |
| payment_proof | varchar | Payment proof file |
| payment_status | enum | pending/valid/invalid |
| registered_at | datetime | Registration time |

### event_internal_links
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| event_id | bigint | FK to events |
| token | varchar | Unique access token |
| name | varchar | Link name/label |
| quota_ikhwan | int | Ikhwan quota for this link |
| quota_akhwat | int | Akhwat quota for this link |
| usage_ikhwan | int | Usage count ikhwan |
| usage_akhwat | int | Usage count akhwat |
| active_from | datetime | Link active from |
| active_until | datetime | Link active until |

### event_attendances
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| event_registration_id | bigint | FK to registrations |
| attended_at | datetime | Attendance time |

---

## Troubleshooting

### Error: "SQLSTATE[42S22]: Column not found"
Run migrations:
```bash
php artisan migrate --force
```

### Error: "The directory does not exist"
Create required folders:
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
Clear all cache:
```bash
php artisan optimize:clear
```

---

Copyright creatorbe ITS Syathiby 2024 - 2026 **KIAS (Kursus Ilmu Bahasa Arab dan Syar'i)**.
