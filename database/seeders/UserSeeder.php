<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

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
            'name'=>'Super Admin',
            'email'=>'sa@smijakartabarat.com',
            'email_verified_at'=>date('Y-m-d H:i:s'),
            'password'=>Hash::make('SA#2022!'),
            'role'=>'SPADM',
            'unit_id'=>1,
            'komwil_id'=>1,
            'created_user'=>1,
        ]);
    }
}
