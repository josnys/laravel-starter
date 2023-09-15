<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Domains\User\Models\Person;
use Illuminate\Database\Seeder;
use Domains\User\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(5)->create();
        // Person::factory()->create();
    }
}
