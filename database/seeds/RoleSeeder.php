<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'admin',
            'moderator',
            'writer',
            'test'
        ];

        foreach ($data as $name) {
            factory(Role::class)->create([
                'name' => $name
            ])->each(function ($role) {
                if ($role->name == 'admin') {
                    $role->permissions()
                        ->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
                } elseif ($role->name == 'moderator') {
                    $role->permissions()
                        ->sync([1, 2, 3, 4, 5, 6]);
                } elseif ($role->name == 'writer') {
                    $role->permissions()
                        ->sync([1, 5]);
                }
            });
        }
    }
}
