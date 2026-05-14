<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            // PermissionTableSeeder::class,
            RoleTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UserTableSeeder::class,
            RoleUserTableSeeder::class,
            ProvincesTableSeeder::class,
            DistrictsTableSeeder::class,
            CommunesTableSeeder::class,
            VillagesTableSeeder::class,
        ]);
        // $this->call(ProvincesTableSeeder::class);
        // $this->call(DistrictsTableSeeder::class);
        // $this->call(CommunesTableSeeder::class);
        // $this->call(VillagesTableSeeder::class);
    }
}
