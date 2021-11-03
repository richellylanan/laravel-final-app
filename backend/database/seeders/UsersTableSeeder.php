<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    private $user;

    /**
     * UsersTableSeeder Constructor.
     * 
     * @param User $user
     * 
     **/
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(1)->create();
    }
}
