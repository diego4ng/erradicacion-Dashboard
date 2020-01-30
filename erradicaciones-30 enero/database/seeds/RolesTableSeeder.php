<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['administrador','invitado','analista','validador'];

        foreach ($roles as $key => $role) {
           
             DB::table('roles')->insert([
                'name'=>$role,
                'created_at'=> Carbon::now()->format('Y-m-d H:i:s')
            ]); 
            
        }
    }
    
}