<?php

namespace Database\Seeders;

use App\Enum\PermissionsEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enum\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Spatie Permission szerepkörök létrehozása az adatbázisban
        // RolesEnum::User->value = 'user' stringet használja a szerepkör neveként
        $userRole = Role::create(['name' => RolesEnum::User->value]);
        $commenterRole = Role::create(['name' => RolesEnum::Commenter->value]);
        $adminRole = Role::create(['name' => RolesEnum::Admin->value]);

        //Permissions létrehozása
        $manageFeaurePermission = Permission::create(['name' => PermissionsEnum::ManageFeatures->value]);
        $manageUsersPermission = Permission::create(['name' => PermissionsEnum::ManageUsers->value]);
        $manageCommentsPermission = Permission::create(['name' => PermissionsEnum::ManageComments->value]);
        $upvoteDownvotePermission = Permission::create(['name' => PermissionsEnum::UpvoteDownvote->value]);

        //Összekötni a Role-t és a Permissiont
        $userRole->syncPermissions([$upvoteDownvotePermission]);
        $commenterRole->syncPermissions([$upvoteDownvotePermission, $manageCommentsPermission]);
        $adminRole->syncPermissions([$manageFeaurePermission, $manageUsersPermission, $manageCommentsPermission,$upvoteDownvotePermission]);



        User::factory()->create([
            'name' => 'User User',
            'email' => 'user@example.com',
        ])->assignRole(RolesEnum::User);

        User::factory()->create([
            'name' => 'Commenter User',
            'email' => 'commenter@example.com',
        ])->assignRole(RolesEnum::Commenter);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ])->assignRole(RolesEnum::Admin);
    }
}
