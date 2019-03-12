<?php

use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(AdminUser::class)
            ->create([
                'name'  => 'Admin User',
                'email' => 'admin@test.com',
                'password' => bcrypt('123')
            ]);
    }
}
