<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// php artisan db:seed --class=PermissionsSeeder
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // if(\Auth::user()->cannot("activity.view.all"))
        //     abort(403);

        // create permissions

        Permission::create(['name' => 'activity.view.user']);
        Permission::create(['name' => 'activity.view.own']);
        Permission::create(['name' => 'activity.view.all']);

        Permission::create(['name' => 'user.add']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.delete']);
        Permission::create(['name' => 'user.view.list']);
        Permission::create(['name' => 'user.view']);

        Permission::create(['name' => 'profile.change.info']);
        Permission::create(['name' => 'profile.change.password']);
        Permission::create(['name' => 'settings.edit']);

        Role::create(['name' => 'Super Admin']);
        User::find(1)->assignRole('Super Admin');
        User::find(1)->givePermissionTo(Permission::all());

    }
}
