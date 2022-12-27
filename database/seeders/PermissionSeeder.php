<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use illuminate\Support\Str;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        if(!Role::where('name', "Super Admin")->where('guard_name', 'web')->first()){

            $guardName = 'web';
            $role = Role::create([
                'name' => 'Super Admin',
                'guard_name' => $guardName
            ]);
            $permissions = [
                    
                    'Super Access' => [
                            'All Access',
                            'Branch Access',
                    ],
                    'Dashboard' => [
                            'Dashboard View',
                            'Total Employee',
                            'Today Attends',
                            'Today Absent',
                            'Leave Request View',
                            
                            'Employee Work Day',
                            'Employee Total Present',
                            'Employee Total Absent',
                            'Employee Total Rest Day',
                    ],
                    'Employee' => [
                            'Employee Create', 
                            'Employee View', 
                            'Employee Edit', 
                            'Employee Delete',
                            'Employee Profile',
                    ],
                    'Branch' => [
                            'Branch Create', 
                            'Branch View', 
                            'Branch Edit', 
                            'Branch Delete',
                    ],
                    'Role' => [
                            'Role Create', 
                            'Role View', 
                            'Role Edit', 
                            'Role Delete',
                    ],
                    'Attendance' => [
                            'Attendance Create', 
                            'Attendance View', 
                            'Attendance Edit', 
                            'Attendance Delete',
                            'Attendance Leave',
                            'Attendance Web Clock',
                    ],
                    'Schedule' => [
                            'Schedule Create', 
                            'Schedule View', 
                            'Schedule Edit', 
                            'Schedule Delete',
                            'Add Attendance',
                    ],
                    'Profile' => [ 
                            'Profile View', 
                            'Profile Edit', 
                            'Change Password',
                            'Profile Schedule View',
                            'Profile Attendance View',
                            'Leave Request',
                    ],
                    'Leave' => [
                            'Leave Request Send', 
                            'Leave Request Approve',
                            'Leave Request Delete',
                    ]
                ];
            


            foreach($permissions as $key => $permission){
                $data = [
                    'group_name' => $key,
                    'group_name_slug' => Str::slug($key),
                    'guard_name' =>$guardName,
                ];

                foreach($permission as $name){
                    $data['name'] = $name;
                    $data['name_slug'] = Str::slug($name);
                    $groupPermisson = Permission::create($data);
                    $role->givePermissionTo($groupPermisson);
                }
            }
        }
    }
}
