<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creación de roles
        $lector = Role::create(['name' => 'Lector']);
        $editor = Role::create(['name' => 'Editor']);
        $administrador = Role::create(['name' => 'Administrador']);

        // Asignación de permisos a roles
        Permission::create(['name' => 'ver_post'])
            ->syncRoles([$editor, $administrador, $lector]);
        Permission::create(['name' => 'descargar_post'])
            ->syncRoles([$administrador]);
        Permission::create(['name' => 'crear_post'])
            ->syncRoles([$editor, $administrador]);
        Permission::create(['name' => 'editar_post'])
            ->syncRoles([$administrador]);
        Permission::create(['name' => 'eliminar_post'])
            ->syncRoles([$administrador]);
        Permission::create(['name' => 'solicitudes.index'])
            ->syncRoles([$administrador]);
    }
}
