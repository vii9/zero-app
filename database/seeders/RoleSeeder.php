<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
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
        Role::truncate();
        $now = Carbon::now()->toDateTimeString();
        $roles =  [
            [
                'name_role' => 'Chúa Tể HĐQT',
                'name_column' => 'SuperAdmin',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name_role' => 'CEO PM',
                'name_column' => 'CEO',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name_role' => 'Ban Biên Tập',
                'name_column' => 'editor',
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'name_role' => 'author',
                'name_column' => 'author',
                'created_at'=> $now,
                'updated_at'=> $now
            ]
        ];

        Role::insert($roles);
    }
}
