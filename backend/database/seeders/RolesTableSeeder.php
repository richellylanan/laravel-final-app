<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    private $role;

    /**
     * RolesTableSeeder Constructor.
     * 
     * @param Role $role
     * 
     **/
    public function __construct(Role $role) {
        $this->role = $role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'created_at' => NOW()
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'created_at' => NOW()
            ]
        ];

        $this->role->insert($roles);
    }
}
