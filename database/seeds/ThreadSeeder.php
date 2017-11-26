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
        $threads = factory('App\Thread', 50)
            ->create()
            ->each(function ($thread) {
                factory('App\Reply', 11)
                    ->create(['thread_id' => $thread->id]);
            });

    }
}
