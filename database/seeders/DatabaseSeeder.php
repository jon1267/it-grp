<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $permissions = [
            'tickets.view',
            'tickets.edit',
            'tickets.change-status',
            'tickets.download-media',
            'users.manage',
        ];

        $permissionsManager = [
            'tickets.view',
            'tickets.edit',
            'tickets.change-status',
            'tickets.download-media',
        ];


        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::findOrCreate('admin')->givePermissionTo($permissions);
        Role::findOrCreate('manager')->givePermissionTo($permissionsManager);

        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
