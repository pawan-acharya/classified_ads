<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $user = factory(App\User::class)->create([
            'email' => 'admin@transfertlocation.ca'
        ]);

    }

}