<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        //
        
        if(!User::where('email', 'admin@admin.com')->first()){
            
            $user = User::create([
                    'branch_id' => 1,
                    'name' => 'Super Admin',
                    'email' => 'admin@admin.com',
                    'phone' => '+1 123 456 7890',
                    'gender' => 'male',
                    'civil' => 'single',
                    'birth_date' => '01/01/1999',
                    'age' => '20',
                    'national_id' => '123456789987',
                    'department' => 'Software',
                    'position' => 'Project Manager',
                    'password' => bcrypt('12345678'),
                ]);
            $user->assignRole('Super Admin');
        }
        
    }
}
