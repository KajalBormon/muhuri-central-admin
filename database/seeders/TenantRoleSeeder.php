<?php

namespace Database\Seeders;

use App\Constants\Constants;
use App\Models\TenantPermission;
use App\Models\TenantRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TenantRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tenant_roles')->truncate();

        $tenantRoles = [
            [
                'id' => 1,
                'name' => Constants::ROLE_SUPER_ADMIN,
                'guard_name' => 'web',
                'is_editable' => true,
                'is_deletable' => false,
                'is_available' => true,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => Constants::ROLE_ADMIN,
                'guard_name' => 'web',
                'is_editable' => true,
                'is_deletable' => false,
                'is_available' => true,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => Constants::ROLE_MANAGER,
                'guard_name' => 'web',
                'is_editable' => true,
                'is_deletable' => false,
                'is_available' => true,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => Constants::ROLE_MUHURI,
                'guard_name' => 'web',
                'is_editable' => true,
                'is_deletable' => false,
                'is_available' => true,
                'is_active' => true,
            ],
        ];
        foreach ($tenantRoles as $tenantRole) {
            TenantRole::create($tenantRole);
        }
        $superAdmin = TenantRole::find(1);
        $permissions = TenantPermission::all();
        $superAdmin->permissions()->sync($permissions);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
