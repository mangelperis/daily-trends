<?php

namespace Database\Seeders;

use App\Models\Feed;
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
        // \App\Models\User::factory(10)->create();

        $label = 'fake-feed';
        $limit = 5;

        for ($i = 1; $i <= $limit; $i++) {
            Feed::create(['title' => sprintf('%s nº %d', $label,$i),
                'body' => 'This is a sample text.',
                'article' => sprintf('%s-%d', $label,$i),
                'image' => null,
                'source' => 'fake-source',
                'publisher' => 'fake-publisher']);
        }
    }
}
