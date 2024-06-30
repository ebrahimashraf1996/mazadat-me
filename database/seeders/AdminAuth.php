<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuth extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'        => 'admin',
            'email'       => 'admin@admin.com',
            'password'    => Hash::make(1234),
            'phone1'      => 123456,
            'phone2'      => 123456,
            'salary'      => 2000,
        ]);
    }
}
