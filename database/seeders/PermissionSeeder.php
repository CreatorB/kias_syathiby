<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            [
                'name' => 'view_user_photos',
                'display_name' => 'Lihat Foto User',
                'group' => 'users',
                'description' => 'Dapat melihat foto profil user/santri'
            ],
            [
                'name' => 'manage_users',
                'display_name' => 'Kelola User',
                'group' => 'users',
                'description' => 'Dapat menambah, edit, hapus user'
            ],
            [
                'name' => 'export_users',
                'display_name' => 'Export Data User',
                'group' => 'users',
                'description' => 'Dapat mengekspor data user ke Excel/PDF'
            ],

            // Santri Management
            [
                'name' => 'manage_santri',
                'display_name' => 'Kelola Data Santri',
                'group' => 'santri',
                'description' => 'Dapat mengelola data santri'
            ],
            [
                'name' => 'verify_payment',
                'display_name' => 'Verifikasi Pembayaran',
                'group' => 'santri',
                'description' => 'Dapat memverifikasi pembayaran pendaftaran'
            ],

            // Event Management
            [
                'name' => 'manage_events',
                'display_name' => 'Kelola Event',
                'group' => 'events',
                'description' => 'Dapat menambah, edit, hapus event'
            ],
            [
                'name' => 'manage_event_participants',
                'display_name' => 'Kelola Peserta Event',
                'group' => 'events',
                'description' => 'Dapat mengelola peserta event'
            ],
            [
                'name' => 'manage_event_attendance',
                'display_name' => 'Kelola Absensi Event',
                'group' => 'events',
                'description' => 'Dapat mengelola absensi event'
            ],

            // Settings
            [
                'name' => 'manage_settings',
                'display_name' => 'Kelola Pengaturan',
                'group' => 'settings',
                'description' => 'Dapat mengubah pengaturan sistem'
            ],
            [
                'name' => 'manage_roles',
                'display_name' => 'Kelola Hak Akses',
                'group' => 'settings',
                'description' => 'Dapat mengatur hak akses role'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
