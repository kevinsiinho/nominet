<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1=Role::create(['name'=>'Admin']);
        $rol2=Role::create(['name'=>'Creador']);
        $rol3=Role::create(['name'=>'Control']);

        Permission::create(['name'=>'crear user'])->syncRoles([$rol1,$rol2]);
        Permission::create(['name'=>'editar user'])->syncRoles([$rol1,$rol2,$rol3]);
        Permission::create(['name'=>'eliminar user'])->syncRoles([$rol1]);

        Permission::create(['name'=>'crear tipoid'])->syncRoles([$rol1,$rol2]);
        Permission::create(['name'=>'editar tipoid'])->syncRoles([$rol1,$rol2]);
        Permission::create(['name'=>'eliminar tipoid'])->syncRoles([$rol1]);

    }
}
