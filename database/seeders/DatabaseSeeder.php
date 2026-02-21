<?php

namespace Database\Seeders;

use Froxlor\Core\Events\DatabaseSeeding;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        event(new DatabaseSeeding($this));
    }
}
