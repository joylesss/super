<?php

use Illuminate\Database\Seeder;

class AppsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Model\Apps::class)->createMany(
            [
                [
                    'name'              => 'Ai Là Triệu Phú',
                    'version_ios'       => '1.0.0',
                    'version_android'   => '1.0.0',
                    'prize'             => '100000',
                    'plan_test'         => '[2020/04]',
                ],
                [
                    'name'              => 'Luyện nghe Tiếng Anh',
                    'version_ios'       => '1.0.0',
                    'version_android'   => '1.0.0',
                    'prize'             => '200000',
                    'plan_test'         => '[2020/06]',
                ],
                [
                    'name'              => 'Nhanh Như Chớt',
                    'version_ios'       => '1.0.0',
                    'version_android'   => '1.0.0',
                    'prize'             => '300000',
                    'plan_test'         => '[2020/08]',
                ]
            ]
        );
    }
}
