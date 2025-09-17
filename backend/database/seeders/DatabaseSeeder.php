<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    
    public function run() {
        // $this->call(UserSeeder::class);
        for($i=0; $i<9; $i++) {
            DB::table('clients')->insert([
                'full_name' => Str::random(10),
                'company_name' => Str::random(10),
                'gender' => 'Male',
                'role' => 'Manager',
                'email' => Str::random(10) . '@gmail.com',
                'mobile' => Str::random(10),
                'address' => Str::random(20),
                'state' => rand(1000, 2000),
                'city' => rand(1, 25),
                'country' => 'India',
                'created_at' => date('Y-m-d H:m:s'),
            ]);
        }

        DB::table('projects_category')->insert(['name' => 'Ecommerce']);
        DB::table('projects_category')->insert(['name' => 'Job Portal']);
        DB::table('projects_category')->insert(['name' => 'Travel']);
        DB::table('projects_category')->insert(['name' => 'CRM']);

        DB::table('technologies')->insert(['name' => 'HTML']);
        DB::table('technologies')->insert(['name' => 'CSS']);
        DB::table('technologies')->insert(['name' => 'Javascript']);
        DB::table('technologies')->insert(['name' => 'PHP']);
        DB::table('technologies')->insert(['name' => 'MySql']);
        DB::table('technologies')->insert(['name' => 'Bootstrap']);
        DB::table('technologies')->insert(['name' => 'Jquery']);
        DB::table('technologies')->insert(['name' => 'Codeigniter']);
        DB::table('technologies')->insert(['name' => 'Laravel']);

        // DB::table('users')->insert([
        //     'name' => 'Vijay Kumar DVK',
        //     'email' => 'admin@vijaykumardvk.com',
        //     'password' => Hash::make('@xWaQrAN@m6Z'),
        // ]);
    }

}
