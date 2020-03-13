<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\Users::class)->createMany([
            [
                'name'      => 'Phan Văn Quí',#$faker->name,
                'phone'     => '0368185092',
                'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role'      => 1,
                'fb_id'     => '100000686899395',
                'fb_email'  => 'bibiphanth11@gmail.com',#$faker->unique()->safeEmail,
                'fb_url'    => '',
            ],
            [
                'name'      => 'Dũng Anh Phùng',#$faker->name,
                'phone'     => '',
                'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role'      => 1,
                'fb_id'     => '1278034745723274',
                'fb_email'  => '',#$faker->unique()->safeEmail,
                'fb_url'    => '',
            ],
            [
                'name'      => 'Name 001',#$faker->name,
                'phone'     => '',
                'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role'      => 0,
                'fb_id'     => '200000686899395',
                'fb_email'  => '',#$faker->unique()->safeEmail,
                'fb_url'    => '',
            ],
            [
                'name'      => 'Name 002',#$faker->name,
                'phone'     => '',
                'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role'      => 0,
                'fb_id'     => '300000686899395',
                'fb_email'  => '',#$faker->unique()->safeEmail,
                'fb_url'    => '',
            ],
            [
                'name'      => 'Name 003',#$faker->name,
                'phone'     => '',
                'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role'      => 0,
                'fb_id'     => '400000686899395',
                'fb_email'  => '',#$faker->unique()->safeEmail,
                'fb_url'    => '',
            ],
        ]);
    }
}
