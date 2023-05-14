<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Alissar Alhajj',
            'email' => 'alissar37alhajj@gmail.com',
            'password' => bcrypt('123456789'),
            'roles_name'=> 'Admin',
            'Status'=>'مفعل'
        ]);
        $role_admin = Role::create(['name' => 'Admin']);
        $role_doctor = Role::create(['name' => 'Doctor']);
        $role_reception = Role::create(['name' => 'Reception']);
        $role_patient = Role::create(['name' => 'Patient']);
        $permissions = Permission::pluck('id', 'id')->all();
        $role_admin->syncPermissions($permissions);
        $user->assignRole([$role_admin->id]);
    }

}
