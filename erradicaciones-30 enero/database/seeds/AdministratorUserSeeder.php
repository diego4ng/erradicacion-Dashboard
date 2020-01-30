<?php

use Illuminate\Database\Seeder;

class AdministratorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@sedena.com',
            'name' => 'Administrador',
            'password' => bcrypt('s0p0rt3')
        ]);

        DB::table('users')->insert([
            'email' => 'invitado@sedena.com',
            'name' => 'Invitado',
            'password' => bcrypt('s0p0rt3')
        ]);

        DB::table('users')->insert([
            'email' => 'analista@sedena.com',
            'name' => 'Analista',
            'password' => bcrypt('s0p0rt3')
        ]);

        DB::table('users')->insert([
            'email' => 'validador@sedena.com',
            'name' => 'Validador',
            'password' => bcrypt('s0p0rt3')
        ]);

        DB::table('user_role')->insert([
            'role_id' => 1,
            'user_id' => 1,
            'status' => 1
        ]);

        DB::table('user_role')->insert([
            'role_id' => 2,
            'user_id' => 2,
            'status' => 1
        ]);

        DB::table('user_role')->insert([
            'role_id' => 3,
            'user_id' => 3,
            'status' => 1
        ]);

        DB::table('user_role')->insert([
            'role_id' => 4,
            'user_id' => 4,
            'status' => 1
        ]);
    }
}
