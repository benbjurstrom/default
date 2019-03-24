<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)
            ->states(['withRoles', 'withAgreements'])
            ->create([
                'email' => 'user@test.com',
                'password' => bcrypt('123')
            ]);
    }
}
