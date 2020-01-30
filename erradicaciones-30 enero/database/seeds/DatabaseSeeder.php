<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'roles',
            'permissions',
            'users',
            'user_role'
        ]);

        // $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(AdministradorUserSeeder::class);

    }

    public function truncateTables(array $tables){

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($tables as $table):
            DB::table($table)->truncate(); //Para poder truncar la tabla con llaves foreneas esto se puede realizar desactivando la revision de llaves foreneas en usuarios profession_id
        endforeach;
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }


}
