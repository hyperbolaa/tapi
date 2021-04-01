<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'uuid' => getUuid(),
            'name' => '管理员',
            'email' => 'admin@cc.com',
            'password' => Hash::make('admin@1573'),
            'role' => 'adminer',
        ]);
        User::create([
            'uuid' => getUuid(),
            'name' => '客服人员',
            'email' => 'custom@cc.com',
            'password' => Hash::make('custom@1573'),
            'role' => 'customer',
        ]);
    }

}
