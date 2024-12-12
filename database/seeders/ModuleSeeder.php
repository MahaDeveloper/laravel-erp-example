<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Modules\Client\Models\User;
use App\Modules\Client\Models\Module;
use App\Modules\Client\Models\Client;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('modules')->truncate();
        DB::table('clients')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
 
        $modules = [
            'Dashboard',
            'Clients',
            'Modules',
            'Privileges',
            'Roles',
            'Users'
        ];

        $basePermissions = ['Create', 'View', 'Edit', 'Delete'];

        foreach ($modules as $module) {

            $createModule = new Module();
            $createModule->name = $module;
            $createModule->save();
            $createModule->order =  $createModule->id;
            $createModule->save();

            foreach ($basePermissions as $basePermission) {
                
                $permission = new Permission();
                $permission->module_id = $createModule->id;
                $permission->operation = $basePermission;
                $permission->guard_name = 'web';
                $permission->name=Str::of($module)->singular()->slug().'-'.Str::lower($basePermission);
                $permission->save();
            }
        }

        $roles = ['SuperAdmin', 'Manager', 'ProjectLead', 'Client'];

        foreach ($roles as $roleName) {
            
            $role = Role::create(['name' => $roleName, 'guard_name' => 'web']);
        
            if ($roleName === 'SuperAdmin') {
                $permissionNames = Permission::all()->pluck('name');
                $role->syncPermissions($permissionNames); 
            }
        }
    
        $client = new Client;
        $client->company_name = "securenext";
        $client->email = "securenext@gmail.com";
        $client->mobile = "9999999999";
        $client->is_superadmin = 1;  //super admin
        $client->is_subscribed = 1;
        $client->company_logo = 'images/clients/default-company.jpg';
        $client->primary_address = 'no5, kottivakkam';
        $client->district = 'Chennai';
        $client->state = 'Tamil nadu';
        $client->country = 'India';
        $client->pin_code = '600041';
        $client->save();
        
        
        $user = new User();
        $user->client_id = $client->id;
        $user->name = 'super admin';
        $user->display_name = 'super admin';
        $user->email = 'securenext@gmail.com';
        $user->mobile = "9999999999";
        $user->password = Hash::make('superAdmin');
        $user->is_primary = 1;
        $user->save();
        $user->assignRole('SuperAdmin');

    }
}
