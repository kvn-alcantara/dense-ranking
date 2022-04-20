<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()
            ->admin()
            ->create();

        $user = User::create([
            'name' => 'Kevin Alcantara',
            'email' => 'kevin@gmail.com',
            'password' => 'secret',
        ]);
        $user->roles()->attach(Role::ADMIN);
    }
}
