<?php

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
use App\Models\TeamMember;

class TeamSeeder extends Seeder
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
            Team::create([
                'uuid' => $res->uuid,
                'name' => '个人组',
                'desc' => '私有',
                'type' => 'private',
            ]);
            Team::create([
                'uuid' => $res->uuid,
                'name' => '空间组',
                'desc' => '私有',
                'type' => 'public',
            ]);
            TeamMember::create([
                'uuid' => $res->uuid,
                'tid'  => 1,
                'role' => 'leader',
            ]);
        }

    }
}
