<?php

use Illuminate\Database\Seeder;
use App\Models\ApiCat;
use App\Models\Api;
use App\Models\User;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $res = User::find(1);

        ApiCat::create([
            'uuid' => $res->uuid,
            'pid'  => 1,
            'name' => '公共分类',
            'desc' => '呵呵哒',
        ]);

        Api::create([
            'pid'       => 1,
            'cat_id'    => 1,
            'name'      => '登录',
            'path'      => '/user/login',
            'creater'   => $res->uuid,
            'updater'   => $res->uuid,
        ]);
        Api::create([
            'pid'       => 1,
            'cat_id'    => 1,
            'name'      => '退出',
            'path'      => '/user/logout',
            'creater'   => $res->uuid,
            'updater'   => $res->uuid,
        ]);
    }
}
