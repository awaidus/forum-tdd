<?php

use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $threads = factory('App\Thread', 20)
            ->create()
            ->each(function ($thread) {
                factory('App\Reply', 5)
                    ->create([ 'thread_id' => $thread->id ]);
            });

        create('App\User', [
            'name'      => 'awaidus',
            'email'     => 'm.awaidus@gmail.com',
            'password'  => bcrypt('pakistan'),
            'confirmed' => 1,
        ]);
    }
}
