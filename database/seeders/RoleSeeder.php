<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles: 1=superadmin, 2=admin, 3=santri, 4=peserta
        $roles = [
            ['id' => 1, 'nama_role' => 'superadmin'],
            ['id' => 2, 'nama_role' => 'admin'],
            ['id' => 3, 'nama_role' => 'santri'],
            ['id' => 4, 'nama_role' => 'peserta'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['id' => $role['id']],
                ['nama_role' => $role['nama_role']]
            );
        }
    }
}
