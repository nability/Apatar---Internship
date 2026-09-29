<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Seed Modules
        $modules = [
            [
                'key'            => 'kuantitatif',
                'label'          => 'Kuantitatif (DDD)',
                'route_prefix'   => 'kuantitatif.index',
                'icon'           => 'fa-solid fa-chart-column',
                'sidebar_order'  => 1,
            ],
            [
                'key'            => 'kualitatif',
                'label'          => 'Kualitatif (Gyssens)',
                'route_prefix'   => 'kualitatif.index',
                'icon'           => 'fa-solid fa-file-medical',
                'sidebar_order'  => 2,
            ],
            [
                'key'            => 'pga',
                'label'          => 'PGA & AWaRe',
                'route_prefix'   => 'pga.index',
                'icon'           => 'fa-solid fa-clipboard-check',
                'sidebar_order'  => 3,
            ],
            [
                'key'            => 'farmasi',
                'label'          => 'Integrasi Farmasi',
                'route_prefix'   => 'integrasi.farmasi',
                'icon'           => 'fa-solid fa-prescription-bottle-medical',
                'sidebar_order'  => 4,
            ],
            [
                'key'            => 'clinical_pathway',
                'label'          => 'Clinical Pathway',
                'route_prefix'   => 'integrasi.clinical-pathway',
                'icon'           => 'fa-solid fa-notes-medical',
                'sidebar_order'  => 5,
            ],
        ];

        $createdModules = [];
        foreach ($modules as $mod) {
            $createdModules[$mod['key']] = Module::create($mod);
        }

        // 2. Seed 4 Roles
        $roleAdmin = Role::create([
            'name'           => 'admin',
            'label'          => 'Administrator Utama',
        ]);

        $roleKuantitatif = Role::create([
            'name'           => 'op_kuantitatif',
            'label'          => 'Operator Kuantitatif',
        ]);

        $roleKualitatif = Role::create([
            'name'           => 'op_kualitatif',
            'label'          => 'Operator Kualitatif',
        ]);

        $rolePGA = Role::create([
            'name'           => 'op_pga',
            'label'          => 'Operator PGA',
        ]);

        // 3. Attach Modules to Roles (Role-Module Access)
        // Admin gets access to all modules with full permissions
        foreach ($createdModules as $module) {
            $roleAdmin->modules()->attach($module->id, [
                'can_view'   => true,
                'can_create' => true,
                'can_edit'   => true,
                'can_delete' => true,
            ]);
        }

        // Operator Kuantitatif gets access to Kuantitatif & Integrasi Farmasi
        $roleKuantitatif->modules()->attach($createdModules['kuantitatif']->id, ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false]);
        $roleKuantitatif->modules()->attach($createdModules['farmasi']->id, ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false]);

        // Operator Kualitatif gets access to Kualitatif & Clinical Pathway
        $roleKualitatif->modules()->attach($createdModules['kualitatif']->id, ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false]);
        $roleKualitatif->modules()->attach($createdModules['clinical_pathway']->id, ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false]);

        // Operator PGA gets access to PGA & Integrasi Farmasi
        $rolePGA->modules()->attach($createdModules['pga']->id, ['can_view' => true, 'can_create' => true, 'can_edit' => true, 'can_delete' => false]);
        $rolePGA->modules()->attach($createdModules['farmasi']->id, ['can_view' => true, 'can_create' => false, 'can_edit' => false, 'can_delete' => false]);

        // 4. Create 4 Users
        $admin = User::create([
            'name'     => 'Admin Utama KPRA',
            'email'    => 'admin@apatar.com',
            'password' => bcrypt('password'),
        ]);
        $admin->roles()->attach($roleAdmin);

        $operatorKuantitatif = User::create([
            'name'     => 'Operator Kuantitatif',
            'email'    => 'user1@apatar.com',
            'password' => bcrypt('password'),
        ]);
        $operatorKuantitatif->roles()->attach($roleKuantitatif);

        $operatorKualitatif = User::create([
            'name'     => 'Operator Kualitatif',
            'email'    => 'user2@apatar.com',
            'password' => bcrypt('password'),
        ]);
        $operatorKualitatif->roles()->attach($roleKualitatif);

        $operatorPGA = User::create([
            'name'     => 'Operator PGA',
            'email'    => 'user3@apatar.com',
            'password' => bcrypt('password'),
        ]);
        $operatorPGA->roles()->attach($rolePGA);
    }
}
