<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$.eHpd3g2FhMSupUP.NLPkeDWBq2o1vvBrhAwM6GwMYHTwxJB9qQdm',
                'remember_token' => '0Yr3JTVjJam1ZYcMKMAmIeTLlcyrryO0JThhB9matmxj8VFm9SvzlbIFuP7S',
                'created_at' => '2023-11-18 00:08:59',
                'updated_at' => '2023-11-18 00:08:59',
                'permissions' => '{"platform.index": true, "platform.systems.roles": true, "platform.systems.users": true, "platform.systems.attachment": true}',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Test',
                'email' => 'test@test.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$v00blyWOVP1Us5qVtZNtE.D77rHuCUKKGG13OhZK1P3L17oRJC/Ra',
                'remember_token' => NULL,
                'created_at' => '2023-11-19 08:24:55',
                'updated_at' => '2023-11-19 08:24:55',
                'permissions' => '{"platform.index": "0", "platform.systems.roles": "0", "platform.systems.users": "0", "platform.systems.attachment": "0"}',
            ),
        ));
        
        
    }
}