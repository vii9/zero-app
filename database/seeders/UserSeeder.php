<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
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
        User::truncate();
        $now = Carbon::now()->toDateTimeString();

        $users =  [
            [
                'name' => 'SuperAdmin',
                'email' => 'thanh130ss@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name' => 'Admin',
                'email' => 'dn2minh@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name' => 'User Editor',
                'email' => 'ag.thanhz@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name' => 'ClientAuthor',
                'email' => 'thanhnhi19092020@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name' => 'SamHoAuthor2',
                'email' => 'dnthanh9agsamho@gmail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'created_at'=> $now,
                'updated_at'=> $now
            ]
        ];

        User::insert($users);
    }
}
