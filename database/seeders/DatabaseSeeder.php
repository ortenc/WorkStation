<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Listing;
use App\Models\User;
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
//         \App\Models\User::factory(5)->create();
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
        ]);

         Listing::factory(6)->create([
             'user_id' => $user->id
         ]);

//         Listing::create([
//             'title' => 'Laravel Senior Developer',
//             'tags' => 'laravel, javascript',
//             'company' => 'Acme Crop',
//             'location' => 'Boston, MA',
//             'email' => 'email1@email.com',
//             'website' => 'https://www.acme.com',
//             'description' => 'Laravel Breeze also offers React and Vue scaffolding via an Inertia frontend implementation. Inertia allows you to build modern, single-page React and Vue applications using classic server-side routing and controllers.'
//         ]);
//
//         Listing::create([
//             'title' => 'Full-Stack Engineer',
//             'tags' => 'laravel, backend,api',
//             'company' => 'Stark Industries',
//             'location' => 'New York, NY',
//             'email' => 'email2@email.com',
//             'website' => 'https://www.starkindustires.com',
//             'description' => 'Laravel Breeze also offers React and Vue scaffolding via an Inertia frontend implementation. Inertia allows you to build modern, single-page React and Vue applications using classic server-side routing and controllers.'
//         ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
