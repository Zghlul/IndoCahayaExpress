<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada (opsional)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        Role::truncate();
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat permissions
        $permissions = [
            ['name' => 'view shipments', 'display_name' => 'Lihat Pengiriman', 'group' => 'shipment'],
            ['name' => 'create shipments', 'display_name' => 'Buat Pengiriman', 'group' => 'shipment'],
            ['name' => 'edit shipments', 'display_name' => 'Edit Pengiriman', 'group' => 'shipment'],
            ['name' => 'delete shipments', 'display_name' => 'Hapus Pengiriman', 'group' => 'shipment'],
            ['name' => 'view users', 'display_name' => 'Lihat Pengguna', 'group' => 'user'],
            ['name' => 'edit users', 'display_name' => 'Edit Pengguna', 'group' => 'user'],
            ['name' => 'delete users', 'display_name' => 'Hapus Pengguna', 'group' => 'user'],
            ['name' => 'manage rates', 'display_name' => 'Kelola Tarif', 'group' => 'rate'],
            ['name' => 'view reports', 'display_name' => 'Lihat Laporan', 'group' => 'report'],
            ['name' => 'access admin panel', 'display_name' => 'Akses Panel Admin', 'group' => 'admin'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        // Buat roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin'], [
            'display_name' => 'Super Administrator',
            'description' => 'Memiliki semua akses'
        ]);
        $adminRole = Role::firstOrCreate(['name' => 'admin'], [
            'display_name' => 'Administrator',
            'description' => 'Mengelola sebagian besar fitur'
        ]);
        $agentRole = Role::firstOrCreate(['name' => 'agent'], [
            'display_name' => 'Agent',
            'description' => 'Hanya melihat dan mengedit pengiriman'
        ]);

        // Assign permissions ke roles
        $superAdminRole->permissions()->sync(Permission::pluck('id')); // semua permission
        $adminRole->permissions()->sync(Permission::whereIn('name', [
            'view shipments', 'create shipments', 'edit shipments', 'delete shipments',
            'view users', 'edit users', 'view reports', 'manage rates', 'access admin panel'
        ])->pluck('id'));
        $agentRole->permissions()->sync(Permission::whereIn('name', [
            'view shipments', 'create shipments', 'edit shipments'
        ])->pluck('id'));

        // Assign role ke user tertentu (ganti 1 dengan ID user admin Anda)
        $user = User::find(1);
        if ($user) {
            $user->roles()->sync([$superAdminRole->id]);
        }
    }
}