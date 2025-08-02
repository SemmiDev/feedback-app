<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Create sample feedbacks
        $feedbacks = [
            [
                'name' => 'John Doe',
                'rating' => 5,
                'comment' => 'Excellent service! I was very impressed with the quality and attention to detail. Will definitely recommend to others.',
            ],
            [
                'name' => 'Jane Smith',
                'rating' => 4,
                'comment' => 'Great experience overall. The staff was helpful and the process was smooth. Minor room for improvement in response time.',
            ],
            [
                'name' => 'Mike Johnson',
                'rating' => 3,
                'comment' => 'Average experience. It was okay but nothing exceptional. Could be better in some areas.',
            ],
            [
                'name' => 'Sarah Wilson',
                'rating' => 5,
                'comment' => 'Outstanding! Exceeded my expectations in every way. Professional, efficient, and friendly service.',
            ],
            [
                'name' => 'David Brown',
                'rating' => 2,
                'comment' => 'Not satisfied with the service. There were several issues that need to be addressed.',
            ],
            [
                'name' => 'Emily Davis',
                'rating' => 4,
                'comment' => 'Good service with room for improvement. Overall positive experience.',
            ],
            [
                'name' => 'Robert Miller',
                'rating' => 5,
                'comment' => null, // No comment
            ],
            [
                'name' => 'Lisa Anderson',
                'rating' => 1,
                'comment' => 'Very disappointed with the service. Multiple problems occurred and were not resolved properly.',
            ],
        ];

        foreach ($feedbacks as $feedback) {
            Feedback::create($feedback);
        }
    }
}
