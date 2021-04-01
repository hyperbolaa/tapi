<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $res = User::find(1);
        if($res){
            Project::create([
                'uuid' => $res->uuid,
                'tid'  => 1,
                'name' => '项目一号',
                'desc' => '来打我啊',
            ]);
        }

    }
}
