<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CoreDatabaseSeeder::class,
            CountrySeeder::class,
            ConfigurationSeeder::class,
            LanguageSeeder::class,
            TenantPermissionSeeder::class,
            TenantRoleSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            FiscalYearSeeder::class,
            ItemSeeder::class,
            ItemUnitSeeder::class,
            SubscriptionPlanSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
            UnionSeeder::class,
            CompanyCategorySeeder::class,
            BrandSeeder::class,
            PaymentMethodSeeder::class,
            JobPositionSeeder::class,
            DepartureReasonSeeder::class
        ]);
    }
}
