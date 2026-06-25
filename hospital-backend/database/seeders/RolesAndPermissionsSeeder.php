<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create basic roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor']);
        
        // Assign 'Super Admin' to all existing users for now so no one is locked out
        $users = User::all();
        foreach ($users as $user) {
            $user->assignRole($superAdminRole);
        }
    }
}
