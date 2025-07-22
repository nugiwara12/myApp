<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder; // ✅ Import RoleSeeder here
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed roles first
        $this->call([
            RoleSeeder::class,
            // SuperAdminSeeder::class
        ]);

        // Super Admin
        {
            $superAdmin = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('superpassword'),
            //    'email_verified_at' => now(),
            ]);

            Role::firstOrCreate(['name' => 'superadmin']);
            $superAdmin->assignRole('superadmin');
        }

        // Admin
        $admin = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Password_121010'),
        ]);
        $admin->assignRole('admin');

        // // Encoder
        // $encoder = User::factory()->create([
        //     'name' => 'Test Encoder',
        //     'email' => 'encoder@example.com',
        //     'password' => bcrypt('Password_121010'),
        // ]);
        // $encoder->assignRole('encoder');

        // // Staff
        // $staff = User::factory()->create([
        //     'name' => 'Test Staff',
        //     'email' => 'staff@example.com',
        //     'password' => bcrypt('Password_121010'),
        // ]);
        // $staff->assignRole('staff');

        // Normal User
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('Password_121010'),
        ]);
        $user->assignRole('user');
    }
}
